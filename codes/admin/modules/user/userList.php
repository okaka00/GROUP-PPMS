<?php
//include db config
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
    <title>User List</title>
</head>

<body>
        <?php
            include '../../includes/sideNav.php'; 
        ?>
        
        <?php
            include '../../includes/topNav.php'; 
        ?>


    <div class="main">
        <h2 style="text-align: center;">User List</h2>
        <div class="rowform">
            <table cellpadding='5' cellspacing='0' width='100%'>";
            <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Role</th>
            <th>Actions</th>
            </tr>

            <?php
            $sql_user = "SELECT u.userID, u.userName, u.userPassword, u.userEmail, r.roleName AS userRole
            FROM user u
            INNER JOIN userRole r
            ON u.roleID = r.roleID
            ORDER BY u.userID ASC";
            $result = mysqli_query($conn, $sql_user);
            $rowcount = mysqli_num_rows($result);
            if ($rowcount > 0) {
                // Dynamically create html table row based on output data of each row from customer table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["userID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userEmail"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userRole"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editUser.php?id=" . urlencode($row["userID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteUser.php?id=" . urlencode($row["userID"]) . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                // Display row and field counts
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }

            // Free result set
            mysqli_free_result($result);
            //close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="../../includes/adminAuth.js"></script>

    </body>
</html>
