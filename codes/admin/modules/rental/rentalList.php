<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Rental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        .rowform {
            border: 1px solid #ccc;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 800px;
            margin: 30px auto;
        }

        /* Styling for the rental details table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
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
        <h2 style="text-align: center;">Manage Rental</h2>
        <div class="rowform">
            <?php
            // Query to select rental details from the database
            $sql_rental = "SELECT r.rentalID, r.userID, r.rentalAmt, r.rentalStatus 
                       FROM rental r 
                       ORDER BY r.rentalID ASC";

            // Executing the query
            $result = mysqli_query($conn, $sql_rental);
            // Counting the number of rows returned by the query
            $rowcount = mysqli_num_rows($result);

            // Checking if any rentals are found
            if ($rowcount > 0) {
                // Displaying rental details in a table
                echo "<table>";
                echo "<tr>";
                echo "<th>Rental ID</th>";
                echo "<th>User ID</th>";
                echo "<th>Rental Amount</th>";
                echo "<th>Rental Status</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                // Looping through the query results to display each rental
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["rentalID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rentalAmt"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rentalStatus"]) . "</td>";
                    echo "<td>";
                    // Providing links for updating or deleting rental records
                    echo "<a href='rentalEdit.php?id=" . urlencode($row["rentalID"]) . "'>Update</a> | ";
                    echo "<a href='rentalDelete.php?id=" . urlencode($row["rentalID"]) . "' onclick='return confirm(\"Are you sure you want to delete this rental?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Displaying the row count for the rentals
                echo "<p>Row Count: $rowcount</p>";
            } else {
                // If no rentals are found
                echo "<p>No rentals found.</p>";
            }
            // Freeing the result set and closing the database connection
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
