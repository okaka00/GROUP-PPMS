<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include db config
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);

    // Another example to retrieve the existing category data using prepared statement
    $sql = "SELECT * FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $userName = $row['userName'];
        $userEmail= $row['userEmail'];
        $userID = $row['userID'];
        $userRoles = $row['roleID'];
        $userPwd = $row['userPassword'];
    } else {
        echo "User not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Category Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPwd = $_POST['userPassword'];
    $userRoles = $_POST['roleID'];

    $pwdHash = trim(password_hash($_POST['userPassword'], PASSWORD_DEFAULT));

    
    $sql = "UPDATE user SET userName = ?,  userEmail = ?, userPassword = ?, roleID = ? WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
   
    if ($pwdHash) {
        // Bind parameters with hashed password
        mysqli_stmt_bind_param($stmt, "sssii", $userName, $userEmail, $pwdHash, $userRoles, $userID);
    } else {
        // Exclude password update if it's empty
        $sql = "UPDATE user SET userName = ?, userEmail = ?, userRole = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $userName, $userEmail, $userRoles, $userID);
    }
    
    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "User Info updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: userList.php");
    exit;
}
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
        <h2 style="text-align: center;">Edit User ID : <?= $userID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="userID" value="<?= isset($userID) ? htmlspecialchars($userID) : 'NONE'; ?>">
                
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" value="<?= htmlspecialchars($userName) ?>" required><br><br>
                
                <label for="userEmail">User Email:</label><br>
                <input type="email" id="userEmail" name="userEmail" value="<?= htmlspecialchars($userEmail) ?>" required><br><br>

                <label for="userPassword">User Password:</label><br>
                <input type="password" id="userPassword" name="userPassword" value="<?= htmlspecialchars($userPwd) ?>" required><br><br>

                <label for="roleID">User Role:</label><br>
                <select id="roleID" name="roleID" required>
                <option value="1" <?= $userRoles == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= $userRoles == 2 ? 'selected' : '' ?>>User</option>
                </select><br><br>
                
                <button type="submit">Update</button>

            </form>
        </div>
    </div>
    <script src="../../includes/adminAuth.js"></script>
</body>

</html>