
		<!-- Forgot Password Popup -->
		<div id="fpwd-popup" class="fpwd-popup">
			<span class="close-btn" onclick="closeFpwdPopup()">&times;</span>
			<h3>User Forgot Password </h3>
			<form action="userAuth/login_action.php" method="post">
				<label for="userEmail">User Email:</label><br>
				<input type="email" id="userEmail" name="userEmail" required><br><br>
				<label for="userPassword">New Password:</label><br>
				<input type="password" id="userPassword" name="userPassword" required maxlength="8" autocomplete="off"><br><br>
                <label for="checkNewPwd">Confirm Password:</label>
                <input type="password" placeholder="ReEnter New Password" id="checkNewPwd" name="confirmNewPwd"required>
				<button type="submit" class="submit-btn" >CONFIRM</button>
				<button type="reset" class="reset-btn" value="Reset">RESET</button>
			</form>
			<p><a href="javascript:void(0);" onclick="closeFpwdPopup();">| Back to Home Page | </a></p>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeFpwdPopup();"></div>
		<!-- End forgot password Popup -->
