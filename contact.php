<?php

/*
THIS FILE USES PHPMAILER INSTEAD OF THE PHP MAIL() FUNCTION
*/

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'assets/vendor/autoload.php';

/* Exception class. */
require 'assets/vendor/phpmailer/phpmailer/src/Exception.php';

/* The main PHPMailer class. */
require 'assets/vendor/phpmailer/phpmailer/src/PHPMailer.php';

/*
CONFIGURATIONS
*/

// an email address that will be in the From field of the email.
$fromEmail = 'info@bestchoicekitchencabinets.ca';
$fromName = 'Contact Form Sender';

// an email address that will receive the email with the output of the form
$sendToEmail = 'info@bestchoicekitchencabinets.ca';
$sendToName = 'Contact Form Recieving';

// subject of the email
$subject = 'New message from web form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'company name' => 'Company Name', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Breif Message Description');

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, We will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try {

    if (count($_POST) == 0) throw new \Exception('Form is empty');

    $emailTextHtml = "<h1>You have a new message from your contact form</h1><hr>";
    $emailTextHtml .= "<table>";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<p>Have a nice day,<br>Regards,<br>Best Choice Kitchen Cabinets</p>";

    $mail = new PHPMailer;

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($sendToEmail, $sendToName); // you can add more addresses by simply adding another line with $mail->addAddress();
    $mail->addReplyTo($from);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->msgHTML($emailTextHtml); // this will also create a plain-text version of the HTML email, very handy

    if (!$mail->send()) {
        throw new \Exception('I could not send the email.' . $mail->ErrorInfo);
    }

    // All the neccessary headers for the email.
    $headers = array(
        'Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );

    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
