<?php
require_once('connectvars.php');

  //Redirect from login page to edit profile if logged in
  if (isset($_COOKIE['user_id']))  {
    $url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php';
    exit(header('Location: ' . $url));
  } 

  //Start session
  session_start();
  
  //Import html head 
  $page_title= 'Sign In';
  require_once('head.php');
  $navClass = 'indexPgNav';

  require_once('login.php');
  require_once('signin.html');
?>