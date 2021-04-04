import * as functions from "firebase-functions";
import * as admin from "firebase-admin";
import * as express from "express";
import * as engines from "consolidate";
import * as recaptcha from "express-recaptcha";
import {RecaptchaResponseV3} from "express-recaptcha/dist/interfaces";
import {body, validationResult, matchedData, Result} from "express-validator";
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
  const data = {name, email, phone, description, score, timestamp};

  // If the score indicates that the request is likely spam, don't save it
  if (score > 0.5) {
    await admin.firestore().collection("quote_requests").add(data);
  }

  await admin.firestore().collection("mail").add({
    toUids: ["user2"],
    ccUids: ["user3"],
    replyTo: email,
    template: {name: quoteRequestTemplateId, data},
  });

  return response.render("success");
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
