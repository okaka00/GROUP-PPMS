<?php
// Include database configuration
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $guidebookID = intval($_GET['id']);

    // Retrieve existing guidebook data
    $sql = "SELECT * FROM guidebook WHERE guidebookID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $guidebookID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $guidebookURL = $row['guidebookURL'];
        $guideDesc = $row['guideDesc'];
        $guidebookImg = $row['guidebookImg'];
    } else {
        echo "Guidebook not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guidebookURL = $_POST['guidebookURL'];
    $guideDesc = $_POST['guideDesc'];
    $updatedDate = date('Y-m-d H:i:s');

    $uploadDir = '../../../uploads/';
    $image = null;

    // Check if a new image is uploaded
    if (isset($_FILES['guidebookImg']) && $_FILES['guidebookImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['guidebookImg']['tmp_name'];
        $fileName = basename($_FILES['guidebookImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT guidebookImg FROM guidebook WHERE guidebookID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $guidebookID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $guidebook = mysqli_fetch_assoc($result);

            if ($guidebook && $guidebook['guidebookImg'] && file_exists($uploadDir . $guidebook['guidebookImg'])) {
                unlink($uploadDir . $guidebook['guidebookImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
        }
    }

    if ($image) {
        $guidebookImg = "uploads/" . $image;
        $sql = "UPDATE guidebook SET guidebookURL = ?, guideDesc = ?, updatedDate = ?, guidebookImg = ? WHERE guidebookID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $guidebookURL, $guideDesc, $updatedDate, $guidebookImg, $guidebookID);
    } else {
        $sql = "UPDATE guidebook SET guidebookURL = ?, guideDesc = ?, updatedDate = ? WHERE guidebookID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $guidebookURL, $guideDesc, $updatedDate, $guidebookID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Guidebook updated successfully!";
        header("Location: guidebookList.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!-- HTML Form -->
<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="guidebookID" value="<?= htmlspecialchars($guidebookID) ?>">
    
    <label for="guidebookURL">Guidebook URL:</label>
    <input type="text" id="guidebookURL" name="guidebookURL" value="<?= htmlspecialchars($guidebookURL) ?>" required><br><br>

    <label for="guideDesc">Guidebook Description:</label><br>
    <textarea id="guideDesc" name="guideDesc" rows="4" cols="50"><?= htmlspecialchars($guideDesc) ?></textarea><br><br>

    <label for="guidebookImg">Guidebook Image:</label><br>
    <?php if ($guidebookImg): ?>
        <img src="<?= BASE_URL . '/' . htmlspecialchars($guidebookImg) ?>" style="width:150px;height:150px;"><br><br>
    <?php endif; ?>
    <input type="file" id="guidebookImg" name="guidebookImg" accept="image/*"><br><br>

    <button type="submit">Update Guidebook</button>
</form>