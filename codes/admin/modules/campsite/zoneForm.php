<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    session_start();
    include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Zone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
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

        .rowform input[type="text"],
        .rowform input[type="file"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #zoneImgPreview {
            display: block;
            margin: 10px auto 20px;
            max-width: 200px;
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
            background-color: gray;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <?php include '../../includes/topNav.php'; ?>

    <!-- Side Navigation -->
    <?php include '../../includes/sideNav.php'; ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Create Zone</h2>
        <div class="rowform">
            <!-- Form to insert a new zone -->
            <form action="zoneInsert.php" method="POST" enctype="multipart/form-data">
                <!-- Zone ID -->
                <label for="zoneID">Zone ID:</label>
                <input type="text" id="zoneID" name="zoneID" placeholder="Enter Zone ID" required><br><br>
                <!-- Zone Description -->
                <label for="zoneDesc">Description:</label>
                <input type="text" id="zoneDesc" name="zoneDesc" placeholder="Enter Zone Description" required><br><br>
                <!-- Zone Image -->
                <label for="zoneImg">Image:</label>
                <input type="file" id="zoneImg" name="zoneImg" accept="image/*" required><br><br>
                <!-- Submit button -->
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- Dropdown Content JS -->
    <script src="../../includes/adminAuth.js"></script>
</body>
</html>
