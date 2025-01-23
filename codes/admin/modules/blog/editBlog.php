<?php
//include db config
include("../../config/config.php");

// Initialize variables to avoid warnings
$image = null;
$blogImg = null;
$createdBy = null;

// Check if ID is provided
if (isset($_GET['id'])) {
    $blogID = intval($_GET['id']);

    // Retrieve existing blog data
    $sql = "SELECT * FROM blog WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $blogTitle = $row['blogTitle'];
        $blogEntry = $row['blogEntry'];
        $blogImg = $row['blogImg'];
        $createdBy = $row['createdBy'];
        $updatedDate = $row['updatedDate'];
    } else {
        echo "Blog not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Product Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogTitle = $_POST['blogTitle'];
    $blogEntry = $_POST['blogEntry'];
    $blogImg = $_POST['blogImg'] ?? null;  // Safely initialize
    $createdBy = $_POST['createdBy'] ?? null;  // Safely initialize
    $updatedDate = $_POST['updatedDate'];

    $uploadDir = '../../../uploads/';
    $image = null;

    // Check if a new image is uploaded
    if (isset($_FILES['blogImg']) && $_FILES['blogImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['blogImg']['tmp_name'];
        $fileName = basename($_FILES['blogImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT blogImg FROM blog WHERE blogID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $blogID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $blog = mysqli_fetch_assoc($result);

            if ($blog && $blog['blogImg'] && file_exists($uploadDir . $blog['blogImg'])) {
                unlink($uploadDir . $blog['blogImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
        }
    }

    if ($image) {
        $blogImg = "uploads/" . $image;
        $sql = "UPDATE blog SET blogTitle = ?, blogEntry = ?, blogImg = ?, createdBy = ?, updatedDate = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisi", $blogTitle, $blogEntry, $blogImg, $createdBy, $updatedDate, $blogID);
    } else {
        $sql = "UPDATE blog SET blogTitle = ?, blogEntry = ?, blogImg = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $blogTitle, $blogEntry, $blogImg, $blogID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Blog updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: blogList.php");
    exit;
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Blog Entry</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Edit Blog ID : <?= $blogID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blogID" value="<?= htmlspecialchars($blogID) ?>">
                
                <label for="blogTitle">Blog Title:</label>
                <input type="text" id="blogTitle" name="blogTitle" value="<?= htmlspecialchars($blogTitle) ?>" required><br><br>

                <label for="blogEntry">Blog Entry:</label><br><br>
                <textarea id="blogEntry" name="blogEntry" rows="4" cols="50" required><?= htmlspecialchars($blogEntry) ?></textarea><br><br>

                <label for="blogImg">Blog Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($blogImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="blogImg" name="blogImg" accept="image/*"><br><br>
                
                <label for="updatedDate">Updated Date:</label>
                <input type="date" id="updatedDate" name="updatedDate" value="<?= htmlspecialchars($updatedDate) ?>" required><br><br>
                
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>

</html>

