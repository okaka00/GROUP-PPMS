<?php include("config/config.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
    </head>
    <body>
        <div class="topNav">
            <img src="<?php echo ADMIN_BASE_URL; ?>/img/icon.png" alt="Logo">
        </div>
        
        <?php
            include 'includes/sideNav.php'; 
        ?>
        
        <!-- Login Popup -->
		<div id="login-popup" class="login-popup">
			<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
			<h3>Admin Login </h3>
			<form action="userAuth/login_action.php" method="post">
				<label for="userEmail">Admin Email:</label><br>
				<input type="email" id="userEmail" name="userEmail" required><br><br>
				<label for="userPwd">Password:</label><br>
				<input type="password" id="userPwd" name="userPwd" required maxlength="8" autocomplete="off"><br><br>
				<input type="submit" value="Login">
				<input type="reset" value="Reset"></br>
			</form>

		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
		<!-- End Login Popup -->


        <div class="main">
            <h2>Admin Panel Dashboard</h2>
            <p>                 Welcome to the dashboard. Here you can manage various settings and options.</p>
        </div>
        
        <script>
            /* JS for dropdown content */
            var dropdown = document.getElementsByClassName("dropdown-btn");
            var i;
            for (i = 0; i < dropdown.length; i++) {
                dropdown[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === "block") {
                        dropdownContent.style.display = "none";
                    } else {
                        dropdownContent.style.display = "block";
                    }
                });
            }


        </script>
    </body>
</html>

