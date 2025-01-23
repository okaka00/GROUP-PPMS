		<!-- Login Popup -->
		<div id="login-popup" class="login-popup">
			<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
			<h3>User Login </h3>
			<form action="userAuth/login_action.php" method="post">
				<label for="userEmail">User Email:</label><br>
				<input type="email" id="userEmail" name="userEmail" required><br><br>
				<label for="userPassword">Password:</label><br>
				<input type="password" id="userPassword" name="userPassword" required maxlength="8" autocomplete="off"><br><br>
				<button type="submit" class="submit-btn" >LOGIN</button>
				<button type="reset" class="reset-btn" value="Reset">RESET</button>
			</form>
			<p><a href="javascript:void(0);" onclick="openRegPopup();">| Registration </a> | Forgot Password |</p>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
		<!-- End Login Popup -->
