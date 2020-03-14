<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  
  if (isset($_POST['update_password'])) {
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
    $password3 = mysqli_real_escape_string($dbc, trim($_POST['password3']));
    $formErr1 ='';
    $formErr2 = '';
    $formErr3 = '';
    $formErr4 = '';
    $formErr5 = '';
    if (empty($password1)) {
        $formErr1 = '*Please enter current password. ';
    }
    if (empty($password2) || empty($password3)) {
        $formErr2 = '*Please enter and confirm password. ';
    } else if ($password2 !== $password3) {
        $formErr3 = '*New password fields must contain same value. ';
    } else if (strlen($password2) < 8 || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/', $password1) !== 1 ) {
        $formErr4 = '*Passwords must be at least six characters long and include at least one capital letter, one special character, and one number. ';
    }

    if (!$formErr1 && !$formErr2 && !$formErr3 && !$formErr4 && !$formErr5 &&
      !empty($password1) && !empty($password2) && !empty($password3) && ($password2 === $password3)) {
    	
      // Check is current password is valid
      $query = "SELECT * FROM profile WHERE user_id = '" . $_SESSION['user_id'] . "'".
            " AND email ='" . $_SESSION['email'] . "' AND password = SHA('$password1')";
      $data = mysqli_query($dbc, $query);

      if (mysqli_num_rows($data) == 1) {
        // Password valid, so update password
        $query = "UPDATE profile SET password = SHA('$password2') " .
        "  WHERE user_id = '" . $_SESSION['user_id'] . "'";
        
        mysqli_query($dbc, $query) or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
        mysqli_close($dbc);
        
        require_once('../../logout.php');
        //$home_url = 'https://' . $_SERVER['HTTP_HOST'];
       	//header('Location: ' . $home_url, true, 303);

        exit();
      } else {
        // Current password invalid. Show errors
        mysqli_close($dbc);
        $formErr5 = 'Password invalid.';
        $home_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?err=' . $formErr1 . $formErr2 . $formErr3 . $formErr4 . $formErr5;
        exit(header('Location: ' . $home_url, true, 303));
      }
    } else {
      mysqli_close($dbc);
      $formErr5 = 'Please enter all mandatory fields';
      $home_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?err=' . $formErr1 . $formErr2 . $formErr3 . $formErr4 . $formErr5;
      exit(header('Location: ' . $home_url, true, 303));
    }
  }
  mysqli_close($dbc);
