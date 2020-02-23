<?php
require_once ('PHPMailer/class.phpmailer.php');
require_once ('PHPMailer/class.smtp.php');
require_once ('PHPMailer/PHPMailerAutoload.php');
$subject = "Sign Up | Credentials - BBB";
$message = "
<html>
    <head>
        <title>HTML Email</title>
    </head>

    <body>
        <p>
            Thank you for signing up with Facebook! Your temporary password is below.  
            It will expire in 7 days from receipt of this e-mail.  Please update 
            your password by clicking the 'Edit Profile' link in the navigation
            bar, then clicking the 'Login Security' tab.  Happy chatting!
         </p>
        <table>
            <tr>
                <td>Firstname: $firstname</td>
            </tr>
            <tr>
                <td>Lastname: $lastname</td>
            </tr>
        </table>
        <p>Automated password (Expires in 7 days): $temp_password</p>
        <p>No-reply automated e-mail.  Do not respond.</p>
    </body>
</html>
";
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                              // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
    $mail->Username   = 'info.bikini.bottom.buddies@gmail.com';   // SMTP username
    $mail->Password   = 'rtvkubrcezisfeom';                       // SMTP password from gmail
    $mail->SMTPSecure = 'ssl';                                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = '465';                                    // TCP port to connect to (465 or 587)

    //Recipients
    $mail->setFrom('no-reply@BikiniBottomBuddies.com', 'Bikini Bottom Buddies');
    $mail->addAddress($email2, $firstname .' '. $lastname);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('no-reply@BikiniBottomBuddies.com', 'Information');
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
    //echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo "Message not sent.";
}
?>