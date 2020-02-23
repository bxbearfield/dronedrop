<?php
    require_once('head.php');
    require_once('connectvars.php');

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_error());

    $email1 = mysqli_real_escape_string($dbc, $_GET['email1']); // Set original email variable
    $email2 = mysqli_real_escape_string($dbc, $_GET['email2']); // Set new email variable
    $hash = mysqli_real_escape_string($dbc, $_GET['hash']); // Set hash variable
    
    if (isset($email1) && !empty($email1) AND 
        isset($email2) && !empty($email2) AND 
        isset($hash) && !empty($hash)) {
        // Verify data
        $query ="SELECT * FROM profile WHERE email='$email1' AND hash='$hash'";
        $search = mysqli_query($dbc, $query); 
                    
        if (mysqli_num_rows($search) == 1) {
            // We have a match, activate the account
            $query2 = "UPDATE profile SET email='$email2' WHERE email='$email1' AND hash='$hash'";
            mysqli_query($dbc, $query2) or die(mysqli_error());
            echo '<div class="verifymsg">Your new e-mail has been successfully verified! Now <a href="index.php">log back in</a> to connect and chat!</div>';
        } else {
            // No match -> invalid url or account has already been activated.
            echo '<div class="verifymsg">This url is invalid or has been activated. Please <a href="index.php">log in</a> or <a href="index.php#signUpPane">sign up</a>.</div>';
        }
                    
    } else {
        // Invalid approach
        echo '<div class="verifymsg">Invalid url, please use the link that has been sent to your email.</div>';
    }
?>