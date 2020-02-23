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

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $accessToken = '';

  // Grab the profile data from the database
  $query = "SELECT IG_AccessToken FROM profile WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query) or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );
  
  if (mysqli_num_rows($data) == 1) {
    //The user row was found so display the user data
     $row = mysqli_fetch_array($data);
     $accessToken = $row['IG_AccessToken'];
  }
	$params = array(
		'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
		'access_token' => $accessToken
	);
	$ig = new instagram_basic_display_api( $params );
	$_SESSION['igActivateUrl'] = $ig->authorizationUrl;
	
	if ($ig->hasUserAccessToken) : 
		$_SESSION['igUser'] = $ig->getUser();
		$_SESSION['igUser']['tokenExpires'] = ceil($ig->getUserAccessTokenExpires()/86400);
	endif;

	if(!$accessToken && $ig->hasUserAccessToken ):
		$query = "UPDATE profile SET IG_AccessToken = '".$ig->getUserAccessToken()."'" .
		" WHERE user_id = '" . $_SESSION['user_id'] . "'";

		$data = mysqli_query($dbc, $query)				
		or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );
  endif;
  
	mysqli_close($dbc);

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