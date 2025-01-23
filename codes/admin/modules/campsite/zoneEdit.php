<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    // Retrieve the zone ID from the GET request. If not provided, redirect to the zone list page.
    $zoneID = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$zoneID) {
        header("Location: zoneList.php");
        exit;
    }

    // Prepare and execute a query to fetch the zone details based on the provided zone ID.
    $sql = "SELECT * FROM zone WHERE zoneID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $zoneID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the zone exists, and if so, retrieve its details.
    if (mysqli_num_rows($result) > 0) {
        $zone = mysqli_fetch_assoc($result);
        $zoneDesc = $zone['zoneDesc'];
        $zoneImg = $zone['zoneImg'];
    } else {
        echo "Zone not found!";
        exit;
    }
    mysqli_stmt_close($stmt);

    // Handle form submission for updating the zone.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the updated zone description from the POST data.
        $zoneDesc = $_POST['zoneDesc'];

        // Define the directory for uploading images.
        $uploadDir = '../../../uploads/';
        $image = null;

        // Check if a new image file has been uploaded without errors.
        if (isset($_FILES['zoneImg']) && $_FILES['zoneImg']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['zoneImg']['tmp_name']; // Temporary file name.
            $fileName = basename($_FILES['zoneImg']['name']); // Original file name.
            $targetPath = $uploadDir . $fileName; // Target file path.

            // Move the uploaded file to the target directory.
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = $fileName; // Store the new file name.

                // If the current zone image exists, delete it.
                if ($zoneImg && file_exists($uploadDir . basename($zoneImg))) {
                    unlink($uploadDir . basename($zoneImg));
                }
            }
        }

        // Update the zone details in the database, including the image if provided.
        if ($image) {
            $zoneImg = "uploads/" . $image;
            $sql = "UPDATE zone SET zoneDesc = ?, zoneImg = ? WHERE zoneID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $zoneDesc, $zoneImg, $zoneID);
        } else {
            $sql = "UPDATE zone SET zoneDesc = ? WHERE zoneID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $zoneDesc, $zoneID);
        }

        // Execute the update query and provide feedback to the user.
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Update Successfully!');
                    window.location.href = 'zoneList.php';
                </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Zone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        /* Styling for the form and its elements */
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

        .rowform input[type="text"],
        .rowform input[type="file"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .rowform img {
            display: block;
            margin: 10px auto 20px;
            max-width: 150px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .rowform button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .rowform button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="topNav">
        <img src="<?php echo ADMIN_BASE_URL; ?>/img/icon.png" alt="Logo">
    </div>

    <!-- Side Navigation Bar -->
    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <!-- Display the zone ID -->
        <h2 style="text-align: center;">Zone ID: <?= htmlspecialchars($zoneID) ?></h2>
        <div class="rowform">
            <!-- Form for updating the zone details -->
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Zone Description -->
                <label for="zoneDesc">Zone Description:</label>
                <input type="text" id="zoneDesc" name="zoneDesc" value="<?= htmlspecialchars($zoneDesc) ?>" required><br><br>

                <!-- Zone Image -->
                <label for="zoneImg">Zone Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($zoneImg) ?>" alt="Current Zone Image"><br><br>
                <input type="file" id="zoneImg" name="zoneImg" accept="image/*"><br><br>

                <!-- Submit button -->
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
