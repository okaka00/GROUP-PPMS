<?php
include("../config/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="css/newstyle.css">
</head>
<body>
<?php

//STEP 1: Form data handling using mysqli_real_escape_string function to escape special characters for use in an SQL query,
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    //Validate pwd and confrimPwd
    if ($userPwd !== $confirmPwd) {
        die("Password and confirm password do not match.");
    }

	//create userID by incrementing 
	$sql = "SELECT MAX(userID) AS maxID FROM user";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$newID = $row['maxID'] + 1;

    //STEP 2: Check if userEmail already exist
	$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";	
	$result = mysqli_query($conn, $sql);
	
    if (mysqli_num_rows($result) == 1) {
		echo "<p ><b>Error: </b> User exist, please register a new user</p>";
		header("Location: " . BASE_URL . "/index.php"); 		
	} else {
		// User does not exist, insert new user record, hash the password		
		$pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT)); 
		//echo $pwdHash;
		$sql = "INSERT INTO user (userID, userName, userEmail, userPassword, roleID) VALUES ('$newID','$userName', '$userEmail', '$pwdHash', 2)";
		if (mysqli_query($conn, $sql)) {
                            // Redirect to index page after successful registration
                            $_SESSION['success_message'] = "Registration successful! Please login.";
                            header("Location: " . BASE_URL . "/index.php"); 
                            exit();                        
		} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}	
	}
}
mysqli_close($conn);

?>

<script src="includes/modalAuth.js"></script>
</body>
</html>
