<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    session_start();
    include("../../config/config.php");

    // Retrieve the campsiteID from the GET request or set it to null if not provided
    $campsiteID = isset($_GET['id']) ? $_GET['id'] : null;

    // Redirect to the campsite list if no campsiteID is provided
    if (!$campsiteID) {
        header("Location: campsiteList.php");
        exit;
    }

    // Prepare an SQL statement to fetch campsite details by campsiteID
    $sql = "SELECT * FROM campsite WHERE campsiteID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $campsiteID); // Bind the campsiteID as a string
    mysqli_stmt_execute($stmt); // Execute the query
    $result = mysqli_stmt_get_result($stmt); // Get the result set

    // Check if the campsite exists
    if (mysqli_num_rows($result) > 0) {
        $campsite = mysqli_fetch_assoc($result); // Fetch the campsite data
        $zoneID = $campsite['zoneID']; // Store the zoneID
        $campsitePrice = $campsite['campsitePrice']; // Store the campsite price
    } else {
        // Display an error if the campsite is not found
        echo "Campsite not found!";
        exit;
    }

    // Close the statement after fetching the data
    mysqli_stmt_close($stmt);

    // Handle the form submission for updating the campsite details
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newCampsiteID = $_POST['campsiteID']; // Get the new campsiteID from the form
        $newPrice = $_POST['campsitePrice']; // Get the new price from the form

        // Prepare an SQL statement to update the campsite details
        $sql = "UPDATE campsite SET campsiteID = ?, campsitePrice = ? WHERE campsiteID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $newCampsiteID, $newPrice, $campsiteID); // Bind parameters

        // Execute the update query
        if (mysqli_stmt_execute($stmt)) {
            // On success, display an alert and redirect to the campsite list page
            echo "<script>
                    alert('Update Successfully!');
                    window.location.href = 'campsiteList.php';
                </script>";
        } else {
            // Display an error message if the query fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close the prepared statement and the database connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Campsite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        /* Styling for the form container */
        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Styling for labels */
        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Styling for input fields */
        .rowform input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Styling for the update button */
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

        /* Hover effect for the button */
        .rowform button:hover {
            background-color: gray;
        }

        /* Styling for read-only input fields */
        .rowform .readonly {
            background-color: #e9ecef;
            cursor: not-allowed;
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
        <h2 style="text-align: center;">Update Campsite ID: <?= htmlspecialchars($campsiteID) ?></h2>
        <div class="rowform">
            <!-- Form for updating campsite details -->
            <form action="" method="POST">
                <!-- Zone ID -->
                <label for="zoneID">Zone ID:</label>
                <input type="text" id="zoneID" name="zoneID" value="<?= htmlspecialchars($zoneID) ?>" class="readonly" readonly><br><br>
                <!-- Campsite ID -->
                <label for="campsiteID">Campsite ID:</label>
                <input type="text" id="campsiteID" name="campsiteID" value="<?= htmlspecialchars($campsiteID) ?>" required><br><br>
                <!-- Campsite Price -->
                <label for="campsitePrice">Price:</label>
                <input type="text" id="campsitePrice" name="campsitePrice" value="<?= htmlspecialchars($campsitePrice) ?>" required><br><br>
                <!-- Submit Button -->
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
    <!-- Dropdown Content JS -->
    <script src="../../includes/adminAuth.js"></script>
</body>
</html>
