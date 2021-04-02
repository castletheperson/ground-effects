<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function died($error) {
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br /><br />";
    echo $error."<br /><br />";
    echo "Please go back and fix these errors.<br /><br />";
    die();
}

// validation expected data exists
if(!isset($_POST['name'])   ||
    !isset($_POST['email']) ||
    !isset($_POST['phone']) ||
    !isset($_POST['description']) ||
    !isset($_POST['g-recaptcha-response'])) {
    died('We are sorry, but there appears to be a problem with the form you submitted.');       
}

$name = $_POST['name']; // required
$email_from = $_POST['email']; // required
$phone = $_POST['phone']; // not required
$description = $_POST['description']; // required
$recaptcha_score = 0.0;

$error_message = "";
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
$string_exp = "/^[A-Za-z .'-]+$/";

if(!preg_match($email_exp, $email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
}

if(!preg_match($string_exp, $name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
}

if(strlen($description) < 2) {
    $error_message .= 'The Description you entered do not appear to be valid.<br />';
}

function verifyRecaptcha() {
    global $recaptcha_score;

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        //'secret' => '6Le__dUZAAAAAImi1BIXFIY4I-tO5Mw_rxZAvLWc', // v2
        'secret' => '6Lc9locaAAAAANCa3S-eAZrWpqY-6p2YysWDGbEf', // v3
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    );

    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    )));

    if ($result === false) {
        return false;
    }

    $result = json_decode($result, false);

    if ($result->success && $result->action === 'submit') {
        $recaptcha_score = $result->score;
        return true;
    } else {
        return false;
    }
    
}

if (!verifyRecaptcha()) {
    $error_message .= 'There was a problem verifying the reCaptcha. Are you a robot?<br />';
}

if(strlen($error_message) > 0) {
    died($error_message);
}

function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}

$email_message .= "Spam probability: ".number_format((1.0 - $recaptcha_score) * 100, 0)."%\n\n";

$email_message .= "Form details below.\n\n";
$email_message .= "Name: ".clean_string($name)."\n";
$email_message .= "Email: ".clean_string($email_from)."\n";
$email_message .= "Telephone: ".clean_string($phone)."\n";
$email_message .= "Description: ".clean_string($description)."\n";

$mail = new PHPMailer(true); // Passing `true` enables exceptions
try {
    //Server settings
    //$mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nwagroundeffects@gmail.com';
    $mail->Password = 'groundhogs';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('nwageffects@gmail.com', 'Ground Effects');
    $mail->addAddress('geffects@yahoo.com');
    $mail->addCC('castlekerr@hotmail.com', 'Castle Kerr');
    $mail->addReplyTo($email_from);

    //Content
    $mail->isHTML(false);
    $mail->Subject = 'Contact Request - ' . $name;
    $mail->Body    = $email_message;

    $mail->send();
} catch (Exception $e) {
    died('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
}

echo "<h3>Thank you for contacting us. We will be in touch with you very soon.</h3>";