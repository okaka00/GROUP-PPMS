<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    // Retrieving the rental ID from the URL (GET method)
    $rentalID = isset($_GET['id']) ? $_GET['id'] : null;

    // If rentalID is not provided, display an error message and exit
    if (!$rentalID) {
        echo "Rental ID is missing.";
        exit;
    }

    // SQL query to retrieve rental details based on the rentalID
    $sql = "SELECT * FROM rental WHERE rentalID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $rentalID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rental = mysqli_fetch_assoc($result);

    // If no rental is found, display an error message and exit
    if (!$rental) {
        echo "Rental not found.";
        exit;
    }

    // SQL query to retrieve tool details based on the toolID associated with the rental
    $sql_tool = "
        SELECT t.toolID, t.toolName, t.toolImg, t.pricePerDay 
        FROM tool t
        WHERE t.toolID = ?";
    $stmt_tool = mysqli_prepare($conn, $sql_tool);
    mysqli_stmt_bind_param($stmt_tool, 'i', $rental['toolID']);
    mysqli_stmt_execute($stmt_tool);
    $result_tool = mysqli_stmt_get_result($stmt_tool);
    $tool = mysqli_fetch_assoc($result_tool);

    // SQL query to retrieve campsite details based on the campsiteID associated with the rental
    $sql_campsite = "
        SELECT c.campsiteID, c.zoneID, c.campsitePrice 
        FROM campsite c
        WHERE c.campsiteID = ?";
    $stmt_campsite = mysqli_prepare($conn, $sql_campsite);
    mysqli_stmt_bind_param($stmt_campsite, 's', $rental['campsiteID']);
    mysqli_stmt_execute($stmt_campsite);
    $result_campsite = mysqli_stmt_get_result($stmt_campsite);
    $campsite = mysqli_fetch_assoc($result_campsite);

    // Handling POST request to update the rental status
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['status'])) {
        $newStatus = mysqli_real_escape_string($conn, $_POST['status']);
    
        // SQL query to update rental status in the database
        $sql_update = "UPDATE rental SET rentalStatus = ? WHERE rentalID = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, 'si', $newStatus, $rentalID);
    
        // If the status update is successful, redirect to rental list with a success message
        if (mysqli_stmt_execute($stmt_update)) {
            echo "<script>
                    alert('Updated Successfully!');
                    window.location.href = 'rentalList.php';
                  </script>";
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_update);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rental Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: black;
            color: white;
        }

        .rowform select{
            width: 40%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Styling for buttons */
        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
        }

        button:hover {
            background-color: #45a049;
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
        <!-- Display rental details -->
        <h2 style="text-align: center;">Rental Detail</h2>
        <div class="rowform">
            <p><strong>Rental ID:</strong> <?php echo htmlspecialchars($rental['rentalID']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($rental['startDate']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($rental['endDate']); ?></p>
            <p><strong>Rental Amount:</strong> <?php echo htmlspecialchars($rental['rentalAmt']); ?></p>
            
            <!-- Rental status update form -->
            <form method="POST" action="" id="updateForm">
                <label for="status"><strong>Update Status:</strong></label>
                <select name="status" id="status">
                    <option value="Pending" <?php if ($rental['rentalStatus'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Completed" <?php if ($rental['rentalStatus'] == 'Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancelled" <?php if ($rental['rentalStatus'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </form>

            <!-- Displaying tool details in a table -->
            <h3>Tool Details:</h3>
            <table>
                <tr>
                    <th>Tool ID</th>
                    <th>Tool Name</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($tool['toolID']); ?></td>
                    <td><?php echo htmlspecialchars($tool['toolName']); ?></td>
                    <td><?php echo htmlspecialchars($tool['pricePerDay']); ?></td>
                </tr>
            </table>
            
            <!-- Displaying campsite details in a table -->
            <h3>Campsite Details:</h3>
            <table>
                <tr>
                    <th>Campsite ID</th>
                    <th>Zone ID</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($campsite['campsiteID']); ?></td>
                    <td><?php echo htmlspecialchars($campsite['zoneID']); ?></td>
                    <td><?php echo htmlspecialchars($campsite['campsitePrice']); ?></td>
                </tr>
            </table>

            <!-- Button to trigger form submission -->
            <button type="button" id="updateButton">Update</button>

        </div>
    </div>

    <script>
        // JavaScript to trigger form submission when the update button is clicked
        document.getElementById('updateButton').onclick = function() {
            document.getElementById('updateForm').submit();
        };
    </script>
</body>
</html>

<?php
    // Freeing result memory and closing the database connection
    mysqli_free_result($result);
    mysqli_free_result($result_tool);
    mysqli_free_result($result_campsite);
    mysqli_close($conn);
?>
