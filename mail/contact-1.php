<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];


$sendTo = 'ztackett11@gmail.com';

$from = 'no-reply@ztackett.com';
//$sendTo = 'recruiting@huntingtonpreppg.com';


// an email address that will receive the email with the output of the form
//$sendTo = 'ztackett11@gmail.com';

// subject of the email
$subject = "Website Contact Form";


// message that will be displayed when everything is OK :)
$okMessage = 'Your message was successfully submitted. Thank you, we will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{
    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "New Email From My Website\n\n\n";

    $emailText .= "Name: $name\n
    Email: $email\n
    Phone: $phone\n
    Message: $message\n";

    // All the neccessary headers for the email.
    $headers = array('Content-type: text/html; charset="iso-8859-1"; ',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
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
