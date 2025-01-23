		<!-- Registration Popup -->
		<div id="reg-popup" class="reg-popup">
			<span class="close-btn" onclick="closeRegPopup()">&times;</span>
			<h3>User Registration </h3>
			<form action="userAuth/register_action.php" method="post">
				<label for="reguserName">Username:</label><br>
				<input type="text" id="reguserName" name="userName" required><br><br>
				<label for="reguserEmail">User Email:</label><br>
				<input type="email" id="reguserEmail" name="userEmail" required><br><br>
				<label for="reguserPwd">Password:</label><br>
				<input type="password" id="reguserPwd" name="userPwd" required maxlength="8"><br><br>
				<label for="regconfirmPwd">Confirm Password:</label><br>
				<input type="password" id="regconfirmPwd" name="confirmPwd" required><br><br>
				<button type="submit" class="submit-btn" value="Register" >REGISTER</button>
				<button type="reset" class="reset-btn" value="Reset">RESET</button>
			</form>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
		<!-- End Registration Popup -->
