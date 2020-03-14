<?php
    $page_title = ' Service Message';
    
    require_once('head.php');
    require_once('connectvars.php');

    $email = isset($_GET['email']) ? mysqli_real_escape_string($dbc, $_GET['email']) : ''; // Set email variable
    $hash = isset($_GET['hash']) ? mysqli_real_escape_string($dbc, $_GET['hash']) : ''; // Set hash variable
    
    if (isset($email) && !empty($email) AND isset($hash) && !empty($hash)) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_error());
    
        // Verify data
        $query ="SELECT * FROM profile WHERE email='$email' AND hash='$hash' AND active=0";
        $search = mysqli_query($dbc, $query); 
                    
        if (mysqli_num_rows($search) == 1) {
            // We have a match, activate the account
            mysqli_query($dbc, "UPDATE profile SET active='1' WHERE email='$email' AND hash='$hash' AND active='0'") or die(mysqli_error());
            $serviceMsg = 'Your new account has been successfully created for \'$email!\' You will now be redirected to the homepage to <a href="index.php?verified=1">log in</a>...';
            mysqli_close($dbc);
            header( "refresh:2;url=index.php"); //Wait 2 seconds before redirect
        } else {
            // No match -> invalid url or account has already been activated.
            $serviceMsg = 'This url is invalid or has been activated. Please <a href="index.php">log in</a> or <a href="index.php#signUpPane">sign up</a>.';
        }
    } else {
        // Invalid approach
        $serviceMsg = 'Invalid url, please use the link that has been sent to your email.';
    }
    require_once('serviceMsg.html');
?>