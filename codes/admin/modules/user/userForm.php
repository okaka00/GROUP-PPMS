<?php
include("../../config/config.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="../../css/admin.css">
  <title>User Form</title>
</head>

<body>
        <?php
            include '../../includes/sideNav.php'; 
        ?>
        
        <?php
            include '../../includes/topNav.php'; 
        ?>
  
  <div class="main">
    <h2 style="text-align: center;">User Form</h2>
    <div class="rowform">
      <form action="insertUser.php" method="POST" enctype="multipart/form-data">
        <label for="userName">User Name:</label><br>
        <input type="text" id="userName" name="userName" required><br><br>

        <label for="userEmail">User Email:</label><br>
        <input type="email" id="userEmail" name="userEmail" required><br><br>

        <label for="userPassword">User Password:</label><br>
        <input type="password" id="userPassword" name="userPassword" required><br><br>

        <label for="userRole">User Role:</label><br>
            <select id="userRole" name="userRole" required>
                <option value="">Select Role</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select><br><br>

        <button type="submit" class="btn">Submit</button>
      </form>
    </div>
  </div>

  <script src="../../includes/adminAuth.js" ></script>
  </body>

</html>