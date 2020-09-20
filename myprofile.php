<?php
	require_once('startsession.php');

	// Insert the page header
	$page_title = ' My Profile';
	require_once('head.php');

	$navClass = 'myProfilePgNav';

	if (!isset($_SESSION['user_id'])) {
		echo '<p class="login">Please <a href="index.php">log in</a> to access this page.</p>';
		exit();
	}
	require_once('connectvars.php');
	require_once('igBasicAPI.php');

	$showUsersHTML = '';
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if(isset($_SESSION['user_id'])) {
		$query = "SELECT * FROM profile WHERE email = " .
				" '".$_SESSION['email']."' AND user_id = '".$_SESSION['user_id']."' ";
		$data = mysqli_query($dbc,$query) 
			or die('SQL_SELECT_ERR' . mysqli_error($dbc) . 'SQL_ERR_NO.' . mysqli_errno($dbc) . 'QUERY_USED '. $query );

		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$picture = $row['picture'];
			$address = $row['address'];
			$lng = $row['lon'];
			$lat = $row['lat'];
			$city = $row['city'];
			$state= $row['state'];
			$zip_code= $row['zip_code'];

			$query = "SELECT * FROM profile";
			$data = mysqli_query($dbc, $query);

			// Loop through the array, formatting it as HTML 
			while ($row = mysqli_fetch_array($data)) { 
				if ($row['user_id'] != $_SESSION['user_id']) {
					include('usersOnlineHTML.php');
				}
			}
			
			mysqli_close($dbc);
		}
	} else {
		//Redirect for log in page if not logged in
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
		header('Location: ' . $home_url);
	}
	//Show stock photo if no photo available
	$imgDisplay = $picture ?
		'<img src="images/uploads/user_'.$_SESSION['user_id'].'/'.$picture.'" id="profilePic"/>'
		:
		'<a href="editprofile.php?picAdd=1"><div class="noData"><i id="profilePic" class="fas fa-user"></i></div></a>';
	echo '<script> var myRoom = "'.(isset($_SESSION['email']) ? md5($_SESSION['email']) : '').'";</script>';
	require_once('myprofile.html');
	echo '<script src="js/nav.js"></script>';
	echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.js"></script>';
	//echo '<script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>';
	echo '<script src="js/chat/chat.js"></script>';
	// echo '</body></html>';
?>
