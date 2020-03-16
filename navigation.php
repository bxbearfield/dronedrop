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
					<a href="https://fontmeme.com/spongebob-squarepants-font/">
						<img 
							src="https://fontmeme.com/permalink/191102/c07b7046cfb9a4665025c7879c02bd62.png" 
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
				<li><a href="#">Community</a></li>
				<li><a href="editprofile.php">Edit Profile</a> </li>
				<li><a href="myprofile.php"> My Profile </a></li>
			</ul>
		</nav>

		<div id="showHamburger">
			<div id="hamburgerContent">
				<ul>
					<li><a href="#">Community</a></li>
					<li><a href="editprofile.php">Edit Profile</a> </li>
					<li><a href="myprofile.php"> My Profile </a></li>
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
			<a href="#signUpPane"><input type="button" class="topbutton" id="button1" value="Sign Up"/>
			<input type="button" id="guest" class="topbutton button2" value="Enter as Guest"/>
	</div>
	
		<div id="toplogo">
			<header>
				<p>
					<a href="https://fontmeme.com/spongebob-squarepants-font/">
						<img 
							src="https://fontmeme.com/permalink/191102/c07b7046cfb9a4665025c7879c02bd62.png" 
							alt="spongebob-squarepants-font" border="0"
						>
					</a>
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
				<a href="#signUpPane"><input type="button" class="topbutton" id="button1" value="Sign Up"/></a>	
			</div>
		</div>
	</div>

<?php } ?>
