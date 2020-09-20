<div id="topNavContainer" class="<?php echo $navClass ?>">

<?php
	if (isset($_SESSION['email'])) {
?>
	<div class="nav_logged_out clearfix <?php echo $navClass ?>">

		<div id="navbuttons">
			<!-- this div is positioned at the top to float right of the preceding elements -->
			<a href="editprofile.php"><input type="button" class="topbutton" id="button1" value="Edit Profile"/></a>
			<form class="topbutton" method="post" action="logout.php" onsubmit="return logout()">
				<input type="submit" class="topbutton button2" value="Log Out"/>
			<form>
		</div>
		<div>
			<header id="toplogo">
				<p>
					<a href="#">
						<img 
							src="https://fontmeme.com/permalink/200916/12876b4bbadb7619bd59730549d15207.png" 
							alt="spongebob-squarepants-font" border="0"
						>
					</a>			
				</p>
			</header>
		</div>

		<nav id="topnavbar <?php echo $navClass ?>">
			<div class="hamburger hide">
				<i class="fas fa-bars"></i>
			</div>	
			
			<ul class="menu_standard" id="navbar">
				<li><a href="editprofile.php">Edit Profile</a> </li>
				<li><a href="myprofile.php"> Community </a></li>
			</ul>
		</nav>

		<div id="showHamburger">
			<div id="hamburgerContent">
				<ul>
					<li><a href="editprofile.php">Edit Profile</a> </li>
					<li><a href="myprofile.php"> Community </a></li>
				</ul>
				<form class="topbutton" method="post" action="logout.php" onsubmit="return logout()">
					<input type="submit" class="topbutton button2" value="Log Out"/>
				<form>	
			</div>
		</div>
	</div>
<?php
	}
	else { 
?>
	<div class="nav_logged_out clearfix <?php echo $navClass ?>">
	    <div id="navbuttons"> 
			<!-- this div is positioned at the top to float right of the preceding elements -->
			<!-- <a href="#signUpPane"><input type="button" class="topbutton" id="button1" value="Sign Up"/></a>
			<input type="button" id="guest" class="topbutton button2" value="Enter as Guest"/> -->
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="realform">
				<div class="login">
					<div class="loginErrMsg">
						<p> 
							<?php 
								if (!empty($error_msg)) {
									echo $error_msg;
								} else if (!empty($msg)) {
									echo $msg;
								}
							?> 
						</p>
					</div>	

					<!-- Login username input -->
					<input 
						placeholder="Email" type="email" class="loginfield" id="email" name="email"
						value= "<?php 
							if (!empty($email1)) { 
								echo $email1;
							} else if(!empty($testEmail)) {
								echo $testEmail;
							} 
						?>" 
					/> 

					<!-- Login password input -->
					<input 
						placeholder="Password" type="password" class="loginfield" id="password" name="password"
						value="<?php 
							if (!empty($password1)) {
								echo $password1;
							} else if (!empty($testPwd)) {
								echo $testPwd;
							} 
						?>" 
					/> 
					
					<span>
						<input class="loginBtn" type="submit" id="submit" value="Log In" name="login"/>
					</span>
				</div>
			</form>
		</div>
	
		<div id="toplogo">
			<header>
				<p>
					<a href="#">
						<img 
							src="https://fontmeme.com/permalink/200916/12876b4bbadb7619bd59730549d15207.png" 
							alt="spongebob-squarepants-font" border="0"
						>
					</a>
					<img id="navLogo" src="images/favicon.png">
				</p>
			</header>
		</div>

		<nav id="topnavbar">
			<div class="hamburger hide">
				<i class="fas fa-bars"></i>
			</div>		
			<ul class="menu_standard" id="navbar">
				<li><a href="#">Home</a></li>
				<li><a href="#">About</a> </li>
				<li><a href="#signUpPane">Get Started</a></li>
			</ul>
		</nav>
		
		<div id="showHamburger">
			<div id="hamburgerContent">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#signUpPane">Get Started</a></li>
				</ul>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="realform">
					<div class="login">
						<div class="loginErrMsg">
							<p> 
								<?php 
									if (!empty($error_msg)) {
										echo $error_msg;
									} else if (!empty($msg)) {
										echo $msg;
									}
								?> 
							</p>
						</div>	

						<!-- Login username input -->
						<input 
							placeholder="Email" type="email" class="loginfield" id="email" name="email"
							value= "<?php 
								if (!empty($email1)) { 
									echo $email1;
								} else if(!empty($testEmail)) {
									echo $testEmail;
								} 
							?>" 
						/> 

						<!-- Login password input -->
						<input 
							placeholder="Password" type="password" class="loginfield" id="password" name="password"
							value="<?php 
								if (!empty($password1)) {
									echo $password1;
								} else if (!empty($testPwd)) {
									echo $testPwd;
								} 
							?>" 
						/> 
						
						<input type="submit" id="submit" value="Log In" class="loginBtn"/>
						
					</div>
				</form>	
			</div>
		</div>
	</div>
<?php } ?>
</div>
