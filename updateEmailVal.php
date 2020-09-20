<?php
require_once ('PHPMailer/class.phpmailer.php');
require_once ('PHPMailer/class.smtp.php');
require_once ('PHPMailer/PHPMailerAutoload.php');
$subject = "Account Update: E-mail Address | DDD";
$message = "
<html>
    <head>
        <title>HTML Email</title>
    </head>

    <body>
        <p>
            You have requested to update your current e-mail address
             to '$email2.' Click the link below to verify your e-mail.
            Otherwise, your e-mail will not be updated.
         </p>
         <p>
            <table>
                <tr>
                    <td>Firstname: $firstname</td>
                </tr>
                <tr>
                    <td>Lastname: $lastname</td>
                </tr> 
            </table>
        </p>
        <table>
            <tr>
                <td>Please click the link below to verify your updated e-mail address:</td>
            </tr>
            <tr>
                <td>http://localhost/dronedropdelivery/verifyEmailUpdate.php?email1=$email1&email2=$email2&hash=$hash</td>
            </tr>
        </table>
    </body>
</html>
";
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'info.bikini.bottom.buddies@gmail.com';                     // SMTP username
    $mail->Password   = 'rtvkubrcezisfeom';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = '465';                                    // TCP port to connect to (465 or 587)

    //Recipients
    $mail->setFrom('no-reply@DroneDropDelivery.com', 'Bikini Bottom Buddies');
    $mail->addAddress($email2, $firstname .' '. $lastname);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('no-reply@DroneDropDelivery.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = strip_tags($message);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo "Message could not be sent.";
}
?>