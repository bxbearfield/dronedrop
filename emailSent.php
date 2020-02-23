<?php
    require_once('head.php');
    require_once('connectvars.php');

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_error());

    $email = mysqli_real_escape_string($dbc, $_GET['email']); // Set email variable
    $firstname = mysqli_real_escape_string($dbc, $_GET['first']); // Set hash variable
    $lastname = mysqli_real_escape_string($dbc, $_GET['last']); // Set hash variable

    if (
        isset($email) && !empty($email) AND 
        isset($firstname) && !empty($firstname) AND
        isset($lastname) && !empty($lastname)
        ) {
            echo '
                <div class="verifymsg">
                    Thank you for signing up! A message has been sent to "'.$email.'". 
                    Please click on the link in the e-mail to verify and activate your account. <a href="index.php">Go back</a>
                </div>';
            
        }  else {
        // Invalid approach
        echo '<div class="verifymsg">Invalid url. Please use the link that has been sent to your email or <a href="index.php#signUpPane"">sign up</a>.</div>';
    }
?>