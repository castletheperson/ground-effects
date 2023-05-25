import {onRequest} from "firebase-functions/v2/https";
import {setGlobalOptions} from "firebase-functions/v2";
import {initializeApp} from "firebase-admin/app";
import {getFirestore, Timestamp} from "firebase-admin/firestore";
import * as express from "express";
import {handlebars} from "consolidate";
import {RecaptchaV3} from "express-recaptcha";
import {RecaptchaResponseV3} from "express-recaptcha/dist/interfaces";
import {body, validationResult, matchedData, Result} from "express-validator";
import axios from "axios";
// import * as quoteRequestTemplate from "./quote_request_email_template.json";
import * as dotenv from "dotenv";
dotenv.config();

const siteKey = process.env.RECAPTCHAV3_SITEKEY;
const secretKey = process.env.RECAPTCHAV3_SECRETKEY;
if (!siteKey) throw new Error("RECAPTCHAV3_SITEKEY is not set");
if (!secretKey) throw new Error("RECAPTCHAV3_SECRETKEY is not set");

const recaptchaVerify: express.Handler = new RecaptchaV3(
    siteKey,
    secretKey,
    {action: "submit", checkremoteip: true}
).middleware.verify;

setGlobalOptions({
  region: "us-central1",
  // enforceAppCheck: true,
});

initializeApp();
const db = getFirestore();

const quoteRequestTemplateId = "quote_request";

// Run this only one time to create the template
// db.collection("mail_templates")
//    .doc(quoteRequestTemplateId)
//    .set(quoteRequestTemplate);

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
  const timestamp = Timestamp.now();
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
  await db.collection("mail").add({
    toUids: ["quote_requests_to_user"],
    replyTo: data.email,
    template: {name: quoteRequestTemplateId, data},
  });
};

const saveToDatabase = async (data: Data): Promise<void> => {
  await db.collection("quote_requests").add(data);
};

const saveToGoogleForm = async (data: Data): Promise<void> => {
  const quoteRequestDoc = await db.doc("google_forms/quote_request").get();
  const gForm = quoteRequestDoc.data();

  if (!gForm) {
    return;
  }

  await axios.post(
      `https://docs.google.com/forms/u/2/d/e/${gForm.id}/formResponse`,
      new URLSearchParams({
        [gForm.fieldIds.name]: data.name,
        [gForm.fieldIds.email]: data.email,
        [gForm.fieldIds.phone]: data.phone,
        [gForm.fieldIds.description]: data.description,
        [gForm.fieldIds.score]: data.score.toString(),
      }),
  );
};

const app = express();
app.engine("hbs", handlebars);
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

exports.submitQuoteV2 = onRequest(app);
