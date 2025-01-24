<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    session_start();
    include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Zone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        /* Styling for the form container */
        .rowform {
            border: 1px solid #ccc;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 800px;
            margin: 30px auto;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        /* Table header and cell styles */
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        /* Table header background color */
        th {
            background-color: black;
            color: white;
        }

        /* Styling for zone images in the table */
        img.zone-img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 8px;
            }

            .zone-img {
                max-width: 60px;
                max-height: 60px;
            }
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
        <h2 style="text-align: center;">Manage Zone</h2>
        <div class="rowform">
            <?php
            // SQL query to fetch zone data ordered by zone ID
            $sql_zone = "SELECT zoneID, zoneDesc, zoneImg FROM zone ORDER BY zoneID ASC";
            $result = mysqli_query($conn, $sql_zone);
            // Get the number of rows returned by the query
            $rowcount = mysqli_num_rows($result);

            // Check if any results were found
            if ($rowcount > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Zone ID</th>";
                echo "<th>Zone Description</th>";
                echo "<th>Zone Image</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                // Loop through each row of data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["zoneID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["zoneDesc"]) . "</td>";
                    echo "<td><img class='zone-img' src='" . BASE_URL . "/" . htmlspecialchars($row["zoneImg"]) . "'></td>";
                    // Create Update and Delete links for the current zone
                    echo "<td>";
                    echo "<a href='zoneEdit.php?id=" . urlencode($row["zoneID"]) . "'>Update</a> | ";
                    echo "<a href='zoneDelete.php?id=" . urlencode($row["zoneID"]) . "' onclick='return confirm(\"Are you sure you want to delete this zone?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Display the total number of rows found
                echo "<p>Row Count: $rowcount</p>";
            } else {
                // Display a message if no zones are found
                echo "<p>No results found.</p>";
            }
            // End the container div
            echo '</div>';
            echo '</div>';
            // Free the memory associated with the result
            mysqli_free_result($result);
            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <!-- Dropdown Content JS -->
    <script src="../../includes/adminAuth.js"></script>
</body>
</html>
