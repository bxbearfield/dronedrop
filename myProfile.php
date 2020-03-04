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
			$gender = $row['gender']==1?'M':'F';
			$dob = $row['month'].'/'.$row['day'].'/'.$row['year'];
			$user_id = $row['email'];
			$accessToken = $row['IG_AccessToken'];
			$private = $row['IG_Private'];

			$query = "SELECT * FROM profile";
			$data = mysqli_query($dbc, $query);

			$showUsersHTML ='<p class="subtextScroll">Click a user and chat now!</p> ';

			// Loop through the array, formatting it as HTML 
			while ($row = mysqli_fetch_array($data)) { 
				if ($row['user_id'] != $_SESSION['user_id']) {
					include('usersOnlineHTML.php');
				}
			}
			
			//Declare parameters for IG API curl calls
			$params = array(
				'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
				'access_token' => $accessToken
			);
			$ig = new instagram_basic_display_api( $params );
			$showIgFeed = '';
			if ($ig->getMedia() && !$private) {
				foreach ($ig->getMedia()['data'] as $post) { 
					//Display ig pictures
					$showIgFeed .= '<img class="igImage" src="'.$post['media_url'].'" />';
				}
			} else {
				$showIgFeed .= '<a href="editprofile.php?igAdd=1"><div class="noData"><span>Click here to retrieve IG profile feed</span></div></a>';
			}
			mysqli_close($dbc);
		}
	} else {
		//Redirect for log in page if not logged in
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
		header('Location: ' . $home_url);
	}
	//Show stock photo if no photo available
	$imgDisplay = $picture ?
		'<img src="images/uploads/user_'.$_SESSION['user_id'].'/'.$picture.'" id="profilePic"/>'
		:
		'<a href="editprofile.php?picAdd=1"><div class="noData"><i id="profilePic" class="fas fa-user"></i><div>Click to add photo</div></div></a>';
		
	require_once('myprofile.html');
	echo '<script src="js/nav.js"></script>';
	echo '<script src="http://localhost/socket.io/"></script>';
	echo '<script> myRoom = "'.(isset($_SESSION['email']) ? md5($_SESSION['email']) : '').'";</script>';
	//echo '<script src="https://127.0.0.1:8080/socket.io/socket.io.js"></script>';
	echo '<script src="js/chat/chat.js"></script>';
	echo '</body></html>';
?>