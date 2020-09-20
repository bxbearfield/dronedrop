<?php
if (!isset($_COOKIE['user_id'])) {
  if (isset($_POST['signupSubmit'])) {
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Grab the profile data from the POST or Facebook API
    $fb = isset($_POST['fbAuth']) ? mysqli_real_escape_string($dbc, trim($_POST['fbAuth'])) : '';
    $lng = isset($_POST['lon']) ? mysqli_real_escape_string($dbc, trim($_POST['lon'])) : '';
    $lat = isset($_POST['lat']) ? mysqli_real_escape_string($dbc, trim($_POST['lat'])) : '';
    $email2 = isset($_POST['email2']) ? mysqli_real_escape_string($dbc, trim($_POST['email2'])) : '';
    $firstname = isset($_POST['firstname']) ? mysqli_real_escape_string($dbc, trim($_POST['firstname'])) : '';
    $lastname = isset($_POST['lastname']) ? mysqli_real_escape_string($dbc, trim($_POST['lastname'])) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($dbc, trim($_POST['address'])) : '';
    $city = isset($_POST['locality']) ? mysqli_real_escape_string($dbc, trim($_POST['locality'])) : '';
    $state = isset($_POST['administrative_area_level_1']) ? mysqli_real_escape_string($dbc, trim($_POST['administrative_area_level_1'])) : '';
    $zip_code = isset($_POST['postal_code']) ? mysqli_real_escape_string($dbc, trim($_POST['postal_code'])) : '';
    $country = isset($_POST['country']) ? mysqli_real_escape_string($dbc, trim($_POST['country'])) : '';
    $password2 = $fb == 'true' ? $temp_password : isset($_POST['password2']) ? mysqli_real_escape_string($dbc, trim($_POST['password2'])) : '';
    $password3 = $fb == 'true' ? $temp_password : isset($_POST['password3']) ? mysqli_real_escape_string($dbc, trim($_POST['password3'])) : '';
    $formErr = '';
    $formErr1 = '';
    $formErr2 = '';
    $formErr3 = '';
    $formErr4 = '';
    $formErr5 = '';
    $formErr6 = '';
    $formErr7 = '';
    $formErr8 = '';
    $formErr9 = '';
    $hash = md5(rand(0,1000));

    if ($fb == "false") {
      if (preg_match('/\S{2,}@\S{2,}\.\S{2,}/', $email2) !== 1) {
        //If email contains 2+ non spaces, an '@', 2+ non spaces, a '.', 2+ non spaces
        $formErr = '*Invalid e-mail address';
      }
      

      if (preg_match('/[^-\'a-zA-Z]+/',  trim($_POST['firstname'])) === 1 || strlen($firstname) < 2) {
        //If name contains anyting other than -, ', or letters
        $formErr2 = '*Invalid first name';
      }

      if (preg_match('/[^-\'a-zA-Z]+/',  trim($_POST['lastname'])) === 1 || strlen($lastname) < 2) {
        $formErr3 = '*Invalid last name';
      }
      if (strlen($address) < 2 ) {
        $formErr1 += '*Please enter valid address';
      }

      if (strlen($city) < 2 ) {
        $formErr9 += '*Please enter valid city';
      }
      
      if (strlen($state) !== 2) {
        $formErr6 += '*Please enter valid state abbreviation';
      }

      if (strlen($country) < 2 ) {
        $formErr7 += '*Please enter valid country';
      }

      if (strlen($zip_code) < 5 ) {
        $formErr8 += '*Please enter a valid zip code';
      }

      if (empty($password2) || empty($password3)) {
        $formErr4 = '*Please enter and confirm password';
      } 
      else if ($password2 !== $password3) {
        $formErr4 = '*Password fields must contain same value';
        $password2 = '';
        $password3 = '';
      } 
      else if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/', trim($_POST['password2'])) !== 1 || strlen($_POST['password2']) < 8 ) {
        $formErr4 = '*Passwords must be at least 8 characters long and 
                  include one capital letter, one special character, and one number.';
      } 
    }
    if (
      !$formErr && !$formErr1 && !$formErr2 && !$formErr3 && !$formErr4 && !$formErr5 && 
      !$formErr6 && !$formErr7 && !$formErr8 && !$formErr9 &&
      !empty($email2) && 
      !empty($firstname) && !empty($lastname) && 
      !empty($address) && !empty($city) && 
      !empty($state) && !empty($zip_code) && 
      !empty($lng) && !empty($lat) && 
      !empty($password2) && !empty($password3) && 
      ($password2 === $password3)) {
    	
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM profile WHERE email = '$email2'";
      $data = mysqli_query($dbc, $query);
      
      if (mysqli_num_rows($data) == 0) {
        if ($fb == 'true') {
          $query = "INSERT INTO profile (email, first_name, last_name, address, city, state, country, zip_code, lon, lat," . 
          " password, hash, temp_pwd, active) VALUES ('$email2', '$firstname', '$lastname', '$address', '$city', '$state', '$country', '$zip_code', '$lng', '$lat', ". 
          " SHA('$password2'), '$hash','$password2', 1)";
        } else {
          $query = "INSERT INTO profile (email, first_name, last_name, address, city, state, country, zip_code, lon, lat," . 
          " password, hash) VALUES ('$email2', '$firstname', '$lastname', '$address', '$city', '$state', '$country', '$zip_code', '$lng', '$lat', ". 
          " SHA('$password2'), '$hash')";
        }
        mysqli_query($dbc, $query);
        
        
        if ($fb == "false"){
          // Confirm success with the user on email sent page
          $formErr5 = 'Your account has been successfully created! An email has been sent to the provided address with a link to validate your account.';
          
          //Send sign-up validation email
          require_once('emailVal.php');
          $url = 'https://' . $_SERVER['HTTP_HOST'] . '/emailSent.php?email='.$email2.'&first='.$firstname.'&last='.$lastname;
          exit(header('Location: ' . $url, true, 303));
        } 
        else if ($fb == "true") {
          if(!empty($email2) && !empty($password2)) {
            // Look up the email and passord in the database
            $query = "SELECT user_id, first_name, last_name, email FROM profile WHERE email = " .
              "'$email2' AND password = SHA1('$password2')";
            $data = mysqli_query($dbc,$query) 
              or die('SQL_SELECT_ERR ---> ' . mysqli_error($dbc) . 'SQL_ERR_NO. ---> ' . mysqli_errno($dbc) . 'QUERY_USED ---> '. $query );
        
            if (mysqli_num_rows($data) == 1) {
              //Log-in is OK so set user ID/email sessions and cookies
              $row = mysqli_fetch_array($data);
              
              $_SESSION['user_id']=$row['user_id'];
              $_SESSION['email']=$row['email'];
              
              setcookie('user_id', $row['user_id'], time() + (60*60*24*60)); //expires in 60 days
              setcookie('email', $row['email'], time() + (60*60*24*60)); //expires in 60 days
              
              //Email temporary password
              $firstname = $row['first_name'];
              $lastname = $row['last_name'];
              require_once('passwordEmail.php');

              $url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?fblogin=1';
              exit(header('Location: ' . $url, true, 303));
            }	
          }
        }
        $_POST = array();
        exit();
      } else {
        // An account already exists for this username, so display an error message
        $_POST['fbAuth'] = "false";
        $formErr5 = 'An account already exists for this username please enter a different email address or log in';
        $email2 = "";
        $email3 = "";
      }
    } else {
      $formErr5 = '*Please enter all mandatory fields';
    }
    mysqli_close($dbc);
  }
}  
?>
