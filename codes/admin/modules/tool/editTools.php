<?php
// Include database configuration
include("../../config/config.php");

// Check if tool ID is provided
if (isset($_GET['id'])) {
    $toolID = intval($_GET['id']);

    // Retrieve the existing tool data using a prepared statement
    $sql = "SELECT * FROM tool WHERE toolID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $toolID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $toolName = $row['toolName'];
        $toolDesc = $row['toolDesc'];
        $pricePerDay = $row['pricePerDay'];
    } else {
        echo "Tool not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Tool Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toolName = $_POST['toolName'];
    $toolDesc = $_POST['toolDesc'];
    $toolPrice = $_POST['toolPrice'];

    $uploadDir = '../../../uploads/';
    $productImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['toolImg']) && $_FILES['toolImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['toolImg']['tmp_name'];
        $fileName = basename($_FILES['toolImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT toolImg FROM tool WHERE toolID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $toolID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $tool = mysqli_fetch_assoc($result);

            if ($tool && $tool['toolImg'] && file_exists($uploadDir . $tool['toolImg'])) {
                unlink($uploadDir . $tool['toolImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $toolImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $toolImg = "uploads/" . $image;
        echo $toolImg;
        $sql = "UPDATE tool SET toolName = ?, toolDesc = ?, toolImg = ?, pricePerDay = ? WHERE toolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssdi", $toolName, $toolDesc, $toolImg, $pricePerDay, $toolID);
    } else {
        $sql = "UPDATE tool SET toolName = ?, toolDesc = ?, pricePerDay = ? WHERE toolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdi", $toolName, $toolDesc,     $pricePerDay, $toolID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_update);
    mysqli_close($conn);

    // Redirect to tools list or display a success message
    header("Location: toolsList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Edit Tool</title>
    <style>
        .main {
            padding: 30px;
        }

        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .rowform input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: gray;
        }
    </style>
</head>

<body>
    <!-- Top navigation bar with logo -->
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>
    
    <?php 
        include '../../includes/sideNav.php'; 
    ?>

    <?php 
        include '../../includes/topNav.php'; 
    ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Edit Tool</h2>
        <div class="rowform">
            <!-- Form for editing tool -->
            <form action="" method="POST">
                <input type="hidden" name="toolID" value="<?= htmlspecialchars($toolID) ?>">

                <label for="toolName">Tool Name:</label>
                <input type="text" id="toolName" name="toolName" value="<?= htmlspecialchars($toolName) ?>" required>

                <label for="toolDesc">Tool Description:</label>
                <input type="text" id="toolDesc" name="toolDesc" value="<?= htmlspecialchars($toolDesc) ?>" required>

                <label for="toolPrice">Tool Price:</label>
                <input type="number" step="0.01" id="toolPrice" name="toolPrice"
                    value="<?= htmlspecialchars($toolPrice) ?>" required>

                <label for="prod_image">Tool Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($toolImg) ?>"
                    style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="toolImg" name="toolImg" accept="image/*"><br><br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>

</html>
