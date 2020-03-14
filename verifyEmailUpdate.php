<?php
    $page_title = ' Service Message';
    
    require_once('head.php');
    require_once('connectvars.php');

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_error());

    $email1 = isset($_GET['email1']) ? mysqli_real_escape_string($dbc, $_GET['email1']) : ''; // Set original email variable
    $email2 = isset($_GET['email2']) ? mysqli_real_escape_string($dbc, $_GET['email2']) : ''; // Set new email variable
    $hash = isset($_GET['hash']) ? mysqli_real_escape_string($dbc, $_GET['hash']) : ''; // Set hash variable
    
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
            $serviceMsg = 'Your updated e-mail has been successfully verified! Now <a href="index.php">log back in</a> to connect and chat!';
            mysqli_close($dbc);
            header( "refresh:2;url=index.php"); //Wait 2 seconds before redirect
        } else {
            // No match -> invalid url or account has already been activated.
            $serviceMsg = 'This url is invalid or has been activated. Please <a href="index.php">log in</a> or <a href="index.php#signUpPane">sign up</a>.';
        }           
    } else {
        // Invalid approach
        $serviceMsg = 'Invalid url, please click the link that has been sent to your email.';
    }
    require_once('serviceMsg.html');
?>