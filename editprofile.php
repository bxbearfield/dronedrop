<?php
  // Start the session
  require_once('startsession.php');
  require_once('connectvars.php');
  
  // Insert the page header
  $page_title = 'Edit Profile';
  $style_sheet = 'editprofile.css';
  $navClass = 'editProfileNav';

  echo '<div class="content editprofile">';
  require_once('head.php');
  
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="loggedOutErr">Please <a href="index.php">log in</a> to access this page.</p>';
    exit();
  }
  include_once('navigation.php');
  require_once('editprofile.html');
  require_once('igBasicAPI.php');

  echo '</div>';
  echo '<script src="js/utils.js"></script>'; 
  echo '<script> igCode = "'.(isset($_GET["code"]) ? $_GET["code"] : '').'";</script>'; 
  echo '<script> fblogin = "'.(isset($_GET["fblogin"]) ? $_GET["fblogin"] : '').'";</script>'; 
  echo '<script> picAdd = "'.(isset($_GET["picAdd"]) ? $_GET["picAdd"] : '').'";</script>'; 
  echo '<script> igAdd = "'.(isset($_GET["igAdd"]) ? $_GET["igAdd"] : '').'";</script>'; 
  echo '<script> verified = "'.(isset($_GET["verified"]) ? $_GET["verified"] : '').'";</script>'; 
  echo '<script src="js/editprofile.js"></script>'; 
  echo '<script src="js/nav.js"></script>'; 
?>