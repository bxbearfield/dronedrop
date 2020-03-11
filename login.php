<?php

//clear error msg
$error_msg= "";

//If the user isn't logged in, try to log them in
if (!isset ($_COOKIE['user_id'])) {
	if (isset($_POST['login'])) {
		//Connect to the database
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to MYSQL Server');
	
		//Grab user-entered log-in data
		$email1 = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password']));
	
		if(!empty($email1) && !empty($password1)) {
			// Look up email and passord in database
			$query = "SELECT user_id, email FROM profile WHERE email = " .
				"'$email1' AND password = SHA1('$password1') AND active = 1";
			$data = mysqli_query($dbc,$query) 
				or die('SQL_SELECT_ERR ---> ' . mysqli_error($dbc) . 'SQL_ERR_NO. ---> ' . mysqli_errno($dbc) . 'QUERY_USED ---> '. $query );
	
			if (mysqli_num_rows($data) == 1) {
				//Log-in is OK so set user ID/email sessions and cookies 
				$row = mysqli_fetch_array($data);
				
				$_SESSION['user_id']=$row['user_id'];
				$_SESSION['email']=$row['email'];
				
				setcookie('user_id', $row['user_id'], time() + (60*60*24*60)); //expires in 60 days
				setcookie('email', $row['email'], time() + (60*60*24*60)); //expires in 60 days
				mysqli_close($dbc);

				//Redirect to editprofile
				$verified = isset($_GET['verified']) ? '?verified=1':'';
				//$url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php' . $verified;
				$url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php' . $verified;
				exit(header('Location: ' . $url));
			}	
			else {
				//The email/passord are incorrect so set an error message
				$error_msg = '*Please enter a valid email and password to log in';
			}
		}
		  else {
			//The email/password are incorrect so set an error message
			$error_msg = '*You must enter your e-mail and password to log in';
		}
	}
} 
?>
