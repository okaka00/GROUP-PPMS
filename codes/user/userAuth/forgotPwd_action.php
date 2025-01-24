<?php
//include db config
session_start();
include("config/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
            <?php

            //STEP 1: Form data handling using mysqli_real_escape_string function to escape special characters for use in an SQL query,
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
                $newPwd = mysqli_real_escape_string($conn, $_POST['userPassword']);
                $confirmNewPwd = mysqli_real_escape_string($conn, $_POST['confirmNewPwd']);

                //Validate pwd and confrimPwd
                if ($newPwd !== $confirmNewPwd) {
                    die("Password and confirm password do not match.");
                }

                //STEP 2: Check if userEmail already exist
                $sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) == 1) {
                    // User exist, insert new user password, hash the password		
                    $pwdHash = trim(password_hash($_POST['userPassword'], PASSWORD_DEFAULT));
                    //echo $pwdHash;
                    $sql = "UPDATE  user  SET userPassword = '$pwdHash' WHERE userEmail = '$userEmail'";
                    if (mysqli_query($conn, $sql)) {
                        // Successful password change
                        echo '<script>alert("Password Update successful! Please login.");</script>';
                        echo '<script type="text/javascript">window.location.href = "' . BASE_URL . '/index.php";</script>';
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        echo '<script>alert("Password Update Fail!.");window.location.href = "' . BASE_URL . '/index.php";</script>';

                    }
                } else {
                    echo "<script>alert('No account found with the provided email address. Please Resgister');</script>";
                    echo '<script type="text/javascript">window.location.href = "' . BASE_URL . '/index.php";</script>';

                }
            }
            mysqli_close($conn);
            ?>
</body>
<script src="includes/modalAuth.js"></script>

</html>
