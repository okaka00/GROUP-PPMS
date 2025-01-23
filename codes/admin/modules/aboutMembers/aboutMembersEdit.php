<?php
// Include database configuration
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $memberID = intval($_GET['id']);

    // Fetch the existing member data
    $sql = "SELECT * FROM aboutMembers WHERE memberID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $memberID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $userID = $row['userID'];
        $memberName = $row['memberName'];
        $memberDesc = $row['memberDesc'];
        $memberImg = $row['memberImg'];
    } else {
        die("Member not found.");
    }
    mysqli_stmt_close($stmt);
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_POST['userID'];
    $memberName = $_POST['memberName'];
    $memberDesc = $_POST['memberDesc'];
    $newImage = null;

    $uploadDir = realpath('../../../uploads/') . '/';
    $memberImgPath = $memberImg; // Retain the existing image path

    // Check if a new image is uploaded
    if (isset($_FILES['memberImg']) && $_FILES['memberImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['memberImg']['tmp_name'];
        $fileName = basename($_FILES['memberImg']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $newImage = $fileName;
            $memberImgPath = "uploads/" . $newImage;

            // Delete the old image file if it exists
            if ($memberImg && file_exists($uploadDir . basename($memberImg))) {
                unlink($uploadDir . basename($memberImg));
            }
        } else {
            die("Failed to upload the new image.");
        }
    }

    // Update the database
    $sql = "UPDATE aboutMembers SET userID = ?, memberName = ?, memberDesc = ?, memberImg = ? WHERE memberID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssi", $userID, $memberName, $memberDesc, $memberImgPath, $memberID);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to about members list or display success
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: aboutMembersList.php");
        exit;
    } else {
        die("Error updating member: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Edit About Member</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Edit About Member ID: <?= htmlspecialchars($memberID) ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="userID">User  ID:</label>
                <input type="number" id="userID" name="userID" value="<?= htmlspecialchars($userID) ?>" required><br><br>

                <label for="memberName">Member Name:</label>
                <input type="text" id="memberName" name="memberName" value="<?= htmlspecialchars($memberName) ?>" required><br><br>

                <label for="memberDesc">Member Description:</label><br>
                <textarea id="memberDesc" name="memberDesc" rows="4" cols="50" required><?= htmlspecialchars($memberDesc) ?></textarea><br><br>

                <label for="memberImg">Member Image:</label><br>
                <?php if (!empty($memberImg)) : ?>
                    <img src="<?= 'http://localhost/campsite/' . htmlspecialchars($memberImg) ?>" style="width:150px;height:150px;"><br><br>
                <?php else : ?>
                    <p>No image available.</p>
                <?php endif; ?>
                <input type="file" id="memberImg" name="memberImg" accept="image/*"><br><br>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
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