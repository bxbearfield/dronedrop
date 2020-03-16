<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $hash = md5( rand(0,1000) );
  $formErr = '';

  function returnErr($err){
    $return_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?err='.$err;
    exit(header('Location: ' . $return_url, true, 303));
  }

  if (isset($_POST['update_email'])) {
    $email1 = mysqli_real_escape_string($dbc, trim($_POST['email1']));
    $email2 = mysqli_real_escape_string($dbc, trim($_POST['email2']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['passwordEm']));

    if (preg_match('/\S{2,}@\S{2,}\.\S{2,}/', $email2) !== 1 ) {
        $formErr = '*Invalid e-mail address';
    }

    if (!$formErr && !empty($email1) && !empty($email2) && !empty($password)) {
    	
      // Make sure someone isn't already registered using this email
      $query2 = "SELECT * FROM profile WHERE email = '$email2'";
      $data = mysqli_query($dbc, $query2);
      
      if (mysqli_num_rows($data) == 0) {
        $query3 = "SELECT * FROM profile " .
        " WHERE user_id = '" . $_SESSION['user_id'] . "' " . 
        " AND password = SHA1('$password') ".
        " AND email = '$email1'";
        $results = mysqli_query($dbc, $query3);

        if(mysqli_num_rows($results) == 1){
          $row = mysqli_fetch_array($results);

          $firstname = $row['first_name'];
          $lastname = $row['last_name'];
          $email1 = $row['email'];

          $query4 = "UPDATE profile SET hash = '$hash' " .
          "  WHERE user_id = '" . $_SESSION['user_id'] . "'";
          mysqli_query($dbc, $query4);

          require_once('../../updateEmailVal.php');

          $url = 'https://' . $_SERVER['HTTP_HOST'] . '/logout.php?msg=Activate new e-mail or log in';
          exit(header('Location: ' . $url, true, 303));
        } else {
          $formErr = 'Password invalid.';
          returnErr($formErr);
        }
      } else {
        // An account already exists for this email, so display an error message
        $formErr = '*An account already exists for the e-mail address submitted. Please try again.';
        returnErr($formErr);
      }
    } else {
      $formErr = '*Please enter all mandatory fields';
      returnErr($formErr);
    }
  }else{mysqli_close($dbc);}
?>