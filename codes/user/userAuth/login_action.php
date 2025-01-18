<?php
session_start();
include("../config/config.php");
?>
<html>
<head>
<title>Login Action</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />
</head>

<body>
<!-- <h2>Login Information</h2> -->
<?php
//login values from login form
$userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
$userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);

// Query to fetch the user details based on email
$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) == 1) {	
	$row = mysqli_fetch_assoc($result);
	// Check if the password matches the hashed password in the database
	if (password_verify($userPwd, $row['userPwd'])) {
  		// Successful login
		$_SESSION["UID"] = $row["userID"];
		$_SESSION["userName"] = $row["userName"];
		$_SESSION["userRoles"] = $row["userRoles"];
		$_SESSION['loggedin_time'] = time();  

		// Redirect based on user role
		if ($row['userRoles'] == 1) { // Admin
			echo '<script type="text/javascript">
				window.location.href = "' . ADMIN_BASE_URL . '/index.php";
			</script>';
		} else { // Normal User
			echo '<script type="text/javascript">
				window.location.href = "' . BASE_URL . '/index.php";
			</script>';
		}
    	exit(); // Make sure to exit after redirection		
    } else {
		// Incorrect password
		echo '<script type="text/javascript">		
			alert("Login error: Incorrect email or password.");
		</script>';
		echo '<a href="' . BASE_URL . 'index.php"> | Login |</a>';
    }		
} else {
	// User does not exist
	echo '<script type="text/javascript">
		alert("Login error: User does not exist.");
	</script>';
	echo '<a href="' . BASE_URL . 'index.php"> | Login |</a>';
} 

mysqli_close($conn);
?>
</body>
</html>