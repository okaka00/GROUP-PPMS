<?php
// Include database configuration
include("../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $memberName = $_POST['memberName'];
    $memberDesc = $_POST['memberDesc'];

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["memberImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["memberImg"]["name"]);
    $upload_ok = 1;

    // Check if image file is valid
    if (isset($_FILES["memberImg"]["tmp_name"]) && !empty($_FILES["memberImg"]["tmp_name"])) {
        $check = getimagesize($_FILES["memberImg"]["tmp_name"]);
        if ($check !== false) {
            $upload_ok = 1;
        } else {
            echo "File is not an image.";
            $upload_ok = 0;
        }
    } else {
        echo "No image file uploaded.";
        $upload_ok = 0;
    }

    // Check if userID exists in the user table
    $userCheckSql = "SELECT * FROM user WHERE userID = '$userID'";
    $userCheckResult = mysqli_query($conn, $userCheckSql);

    if (mysqli_num_rows($userCheckResult) === 0) {
        echo "Invalid userID value. The user does not exist.";
        $upload_ok = 0;
    }

    // Proceed only if all checks pass
    if ($upload_ok) {
        if (move_uploaded_file($_FILES["memberImg"]["tmp_name"], $target_file)) {
            // Insert data into the aboutMembers table
            $sql = "INSERT INTO aboutMembers (userID, memberName, memberDesc, memberImg)
                    VALUES ('$userID', '$memberName', '$memberDesc', '$target_fileDB')";

            if (mysqli_query($conn, $sql)) {
                echo "<br>New member record created successfully.";
                echo "<br><a href='aboutMembersList.php'>Back to About Members List</a>";
            } else {
                echo "<br>Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

mysqli_close($conn);
?>