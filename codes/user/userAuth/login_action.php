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
$userPwd = mysqli_real_escape_string($conn, $_POST['userPassword']);

// Query to fetch the user details based on email
$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) == 1) {	
	$row = mysqli_fetch_assoc($result);
	// Check if the password matches the hashed password in the database
	if (password_verify($userPwd, $row['userPassword'])) {
  		// Successful login
		$_SESSION["UID"] = $row["userID"];
		$_SESSION["userName"] = $row["userName"];
		$_SESSION["userRole"] = $row["roleID"];
		$_SESSION['loggedin_time'] = time();  

		// Redirect based on user role
		if ($row['roleID'] == 1) { // Admin
			header("Location: " . ADMIN_BASE_URL . "/index.php");	} 
		else { // Normal User
			header("Location: " . BASE_URL . "/index.php");		}
    	exit(); // Make sure to exit after redirection		
    } else {
		// Incorrect password
		echo 'Login error, user email and password is incorrect.<br>';//user email & pwd not correct	
		header("Location: " . BASE_URL . "/index.php");                       
	}		
	} else {
	// User does not exist
	echo "Login error, user <b>$userEmail</b> does not exist. <br>";//user not exist
	header("Location: " . BASE_URL . "/index.php");                
	} 

mysqli_close($conn);
?>
</body>
</html>
