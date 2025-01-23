<?php
// Include database configuration
include("../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guidebookURL = $_POST['guidebookURL'] ?? '';
    $guideDesc = $_POST['guideDesc'] ?? '';
    $userID = 1; // Replace with actual user ID
    $createdDate = date('Y-m-d H:i:s');
    $updatedDate = date('Y-m-d H:i:s');

    // Handle image upload
    $uploads_dir = "../../../uploads/";
    $filename = basename($_FILES["guidebookImg"]["name"]);
    $relative_path = "uploads/" . $filename;
    $target_file = $uploads_dir . $filename;
    $upload_ok = 1;

    if (isset($_FILES["guidebookImg"]) && $_FILES["guidebookImg"]["tmp_name"] !== "") {
        $check = getimagesize($_FILES["guidebookImg"]["tmp_name"]);
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

    if ($upload_ok && move_uploaded_file($_FILES["guidebookImg"]["tmp_name"], $target_file)) {
        // Use prepared statements
        $sql = "INSERT INTO guidebook (guidebookURL, guideDesc, userID, createdDate, updatedDate, guidebookImg)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $guidebookURL, $guideDesc, $userID, $createdDate, $updatedDate, $relative_path);

        if ($stmt->execute()) {
            echo "<div class='success-message'>Guidebook added successfully!</div>";
            header("Location: guidebookList.php");
            exit;
        } else {
            echo "<br>Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css"> <!-- Adjust path as necessary -->
    <title>Add Guidebook</title>
</head>
<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Add New Guidebook</h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="guidebookURL">Guidebook URL:</label>
                <input type="text" id="guidebookURL" name="guidebookURL" required><br><br>

                <label for="guideDesc">Guidebook Description:</label><br>
                <textarea id="guideDesc" name="guideDesc" rows="4" cols="50"></textarea><br><br>

                <label for="guidebookImg">Guidebook Image:</label>
                <input type="file" id="guidebookImg" name="guidebookImg" accept="image/*"><br><br>

                <button type="submit">Add Guidebook</button>
            </form>
        </div>
    </div>
</body>
</html>
