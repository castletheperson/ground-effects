import * as functions from "firebase-functions";
import * as admin from "firebase-admin";
import * as express from "express";
import * as engines from "consolidate";
import * as recaptcha from "express-recaptcha";
import {RecaptchaResponseV3} from "express-recaptcha/dist/interfaces";
import {body, validationResult, matchedData, Result} from "express-validator";
import * as unirest from "unirest";
import * as quoteRequestTemplate from "./quote_request_email_template.json";

const recaptchaVerify: express.Handler = new recaptcha.RecaptchaV3(
    functions.config().recaptchav3.sitekey,
    functions.config().recaptchav3.secretkey,
    {action: "submit", checkremoteip: true}
).middleware.verify;

const quoteRequestTemplateId = "quote_request";
admin.initializeApp();
admin.firestore().collection("mail_templates")
    .doc(quoteRequestTemplateId)
    .set(quoteRequestTemplate);

type Data = {
  name: string,
  email: string,
  phone: string,
  description: string,
  score: number,
  timestamp: FirebaseFirestore.Timestamp,
};

const submitQuote: express.Handler = async (request, response, next) => {
  // Validate request
  const result = validationResult(request);
  const hasErrors = !result.isEmpty();
  if (hasErrors) {
    return next(result);
  }

  const {name, email, phone, description} = matchedData(request);
  const score = (request.recaptcha as RecaptchaResponseV3).data?.score ?? 0.0;
  const timestamp = admin.firestore.Timestamp.now();
  const data: Data = {name, email, phone, description, score, timestamp};

  // If the score indicates that the request is likely spam, don't email it
  if (score > 0.5) {
    await sendEmail(data);
  }

  await saveToDatabase(data);
  await saveToGoogleForm(data);

  return response.render("success");
};

const sendEmail = async (data: Data): Promise<void> => {
  await admin.firestore().collection("mail").add({
    toUids: ["quote_requests_to_user"],
    replyTo: data.email,
    template: {name: quoteRequestTemplateId, data},
  });
};

const saveToDatabase = async (data: Data): Promise<void> => {
  await admin.firestore().collection("quote_requests").add(data);
};

const saveToGoogleForm = async (data: Data): Promise<void> => {
  const gForm = await admin
      .firestore()
      .doc("google_forms/quote_request")
      .get()
      .then((doc) => doc.data());

  if (!gForm) {
    return;
  }

  const url = `https://docs.google.com/forms/u/2/d/e/${gForm.id}/formResponse`;
  await unirest("POST", url)
      .form({
        [gForm.fieldIds.name]: data.name,
        [gForm.fieldIds.email]: data.email,
        [gForm.fieldIds.phone]: data.phone,
        [gForm.fieldIds.description]: data.description,
        [gForm.fieldIds.score]: data.score,
      });
};

const app = express();
app.engine("hbs", engines.handlebars);
app.set("views", "./views");
app.set("view engine", "hbs");
app.use(express.urlencoded({extended: true}));
app.post(
    "/submit-quote",
    body([
      "name",
      "email",
      "phone",
      "description",
      "g-recaptcha-response",
    ], "Invalid request").exists(),
    body("name", "Invalid name").matches(/^[A-Za-z .'-]+$/),
    body("email", "Invalid email address").isEmail(),
    body("phone", "Invalid phone number").isMobilePhone("en-US"),
    body("description", "Description required").notEmpty().escape(),
    recaptchaVerify,
    body("g-recaptcha-response", "Invalid captcha. Are you a robot?")
        .custom((_value, {req: {recaptcha: {error}}}) => !error),
    submitQuote
);

// Handle errors
app.use(((error: Result, _request, response, next) => {
  if (response.headersSent) {
    return next(error);
  }
  const errors = error.formatWith(({msg}) => msg).array();
  return response.status(500).render("error", {errors});
}) as express.ErrorRequestHandler);

exports.submitQuote = functions.https.onRequest(app);
