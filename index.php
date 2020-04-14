<?php
  error_reporting(-1);
  ini_set('display_errors', 'On');
  //set_error_handler("var_dump");
  require_once('connectvars.php');
  echo "<pre>";
  print_r($_GET);
  echo "</pre>";
  
  //Redirect from login page to edit profile if logged in
  if (isset($_COOKIE['user_id']))  {
    $url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php';
    exit(header('Location: ' . $url));
  } 

  //Start session
  session_start();
  
  //Import html head 
  $page_title= 'Home';
  require_once('head.php');

  //Generate random temp password
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

  $navClass = 'indexPgNav';
  $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
  $testEmail = isset($_GET['test']) ? 'test@test.com' : '';
  $testPwd = isset($_GET['test']) ? 'Test.1999' : '';

  //Fb sign up temp pwd
  $temp_password = randomPassword();
  
  require_once('login.php');
  require_once('signup.php'); 

  require_once('login.html');
  echo '<script src="js/nav.js"></script>';
  require_once('signup.html');
  echo '<script src="js/utils.js"></script>';
  require_once('js/signupFB.js.php');
?>
