<?php
		if (isset($_SESSION['username'])) {
?>
	</div>
		</div>	
			<footer>
				<ul id="bottommenu">
					<li><a href="viewprofile.php">My Profile</a></li>
					<li><a href="editprofile.php">Edit Profile</a> </li>
					<li><a href="//facebook.com"> Community </a></li>
				</ul>
			</footer>	
	</body>
</html>

	<?php
		}
		
		
		
		else {
	?>
	</div>
		</div>	
			<footer class="clearfix">
				<ul class="menu_standard" id="bottomnav">
					<li><a href="login.php">Home</a></li>
					<li><a href="//twitter.com">About</a> </li>
					<li><a href="//facebook.com"> Get Started</a></li>
					<li><a href="#"  id="terms"><span> Terms of Service</a></span></li>
				</ul>
				<p class="subtext">
					Copyright &copy; 2020 Bikini Bottom Buddies
				</p>
			</footer>				
	</body>
</html>
			
		<?php } ?>

