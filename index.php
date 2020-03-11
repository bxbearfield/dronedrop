<?php
  error_reporting(-1);
  ini_set('display_errors', 'On');
  //set_error_handler("var_dump");
  require_once('connectvars.php');
  // echo "<pre>";
  // print_r($GLOBALS);
  // echo "</pre>";
  
  //start session
  session_start();
  
  $page_title= 'Home';
  require_once('head.php');
  
  $navClass = 'myProfilePgNav';
  

  function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890.%*&@#';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
  //Fb sign up temp pwd
  $temp_password = randomPassword();
  
  if (!isset ($_COOKIE['user_id'])) {
    if (isset($_POST['login'])) {
      require_once('login.php');
    } 
    else if (isset($_POST['signup'])){
      require_once('signup.php');
    }
  }else{
	//Redirect from log in page to edit profile if logged in
	$url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php';
	exit(header('Location: ' . $url));
} 

  require_once('login.html');
  echo '<script src="js/nav.js"></script>';
  require_once('signup.html');
  echo '<script src="js/utils.js"></script>';
  require_once('js/signupFB.js.php');
?>
