<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $hash = md5( rand(0,1000) );
  $formErr = '';

  if (isset($_POST['update_email'])) {
    $email2 = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['passwordEm']));

    if (preg_match('/\S{2,}@\S{2,}\.\S{2,}/', $email2) !== 1 ) {
        $formErr = '*Invalid e-mail address';
    }

    if (!$formErr && !empty($email2) && !empty($password)) {
    	
      // Make sure someone isn't already registered using this email
      $query2 = "SELECT * FROM profile WHERE email = '$email2'";
      $data = mysqli_query($dbc, $query2);
      
      if (mysqli_num_rows($data) == 0) {
        $query3 = "SELECT * FROM profile " .
        "  WHERE user_id = '" . $_SESSION['user_id'] . "' AND password = SHA('$password') ";
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
          require_once('../../logout.php');

          mysqli_close($dbc);

          $home_url = 'https://' . $_SERVER['HTTP_HOST'];
          header('Location: ' . $home_url, true, 303);
          
          echo $formErr5;
          exit();
        }else {
          $formErr5 = 'PASSWORD INVALID.';
          echo $formErr5;
        }
      } else {
        // An account already exists for this email, so display an error message
        $formErr5 = '*An account already exists for the e-mail address submitted. Please try again.';

        $home_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?err='.$formErr5;
        header('Location: ' . $home_url, true, 303);
        $email2 = "";
      }
    } else {
      $formErr5 = '*Please enter all mandatory fields';
      echo $formErr5;
    }
  }else{mysqli_close($dbc);}
