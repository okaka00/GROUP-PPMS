<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include db config
include("../../config/config.php");


// Retrieve the maximum existing ID
$sql = "SELECT MAX(userID) AS maxID FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newID = $row['maxID'] + 1; // Increment the maximum ID by 1
} else {
    $newID = 1; // Start from 1 if no records exist
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPwd = $_POST['userPaswword'];
    $userRoles = $_POST['userRole'];

    $pwdHash = trim(password_hash($_POST['userPassword'], PASSWORD_DEFAULT));

     $sql = "INSERT INTO user (userID, userName, userEmail, userPassword, roleID)
     VALUES ('$newID', '$userName', '$userEmail', '$pwdHash', '$userRoles')";

     if (mysqli_query($conn, $sql)) {
        echo "<br>New user record created successfully";
     } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
     }
    }
mysqli_close($conn);
header("Location:userList.php");

?>
