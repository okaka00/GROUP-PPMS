<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    session_start();
    include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Campsite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        /* Styling table for the campsite management page */
        .rowform {
            border: 1px solid #ccc;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 800px;
            margin: 30px auto;
        }

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

        .zone-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .zone-filter select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
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
        <h2 style="text-align: center;">Manage Campsite</h2>

        <!-- Zone filter form to filter campsites by zone -->
        <div class="zone-filter">
            <form method="GET" action="">
                <label for="zoneID">Filter by Zone:</label>
                <select name="zoneID" id="zoneID" onchange="this.form.submit()">
                    <option value="">All Zones</option>
                
                    <?php
                        // Fetch zone IDs from the database and populate the dropdown
                        $sql_zones = "SELECT zoneID FROM zone ORDER BY zoneID ASC";
                        $zones_result = mysqli_query($conn, $sql_zones);

                        while ($zone = mysqli_fetch_assoc($zones_result)) {
                            $selected = (isset($_GET['zoneID']) && $_GET['zoneID'] == $zone['zoneID']) ? 'selected' : '';
                            echo "<option value=\"" . htmlspecialchars($zone['zoneID']) . "\" $selected>" . htmlspecialchars($zone['zoneID']) . "</option>";
                        }
                        mysqli_free_result($zones_result);
                    ?>

                </select>
            </form>
        </div>

        <!-- Campsite management table -->
        <div class="rowform">
            <?php
                // Check if a zone filter is applied
                $zoneFilter = isset($_GET['zoneID']) ? $_GET['zoneID'] : '';

                // Query to fetch campsites, optionally filtered by zone
                $sql_campsite = "SELECT c.campsiteID, c.campsitePrice, z.zoneID 
                                FROM campsite c
                                JOIN zone z ON c.zoneID = z.zoneID";

                if (!empty($zoneFilter)) {
                    $sql_campsite .= " WHERE z.zoneID = '" . mysqli_real_escape_string($conn, $zoneFilter) . "'";
                }

                $sql_campsite .= " ORDER BY c.campsiteID ASC";

                // Execute the query and fetch results
                $result = mysqli_query($conn, $sql_campsite);
                $rowcount = mysqli_num_rows($result);

                if ($rowcount > 0) {
                    // Display results in a table format
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Zone ID</th>";
                    echo "<th>Campsite ID</th>";
                    echo "<th>Campsite Price</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["zoneID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["campsiteID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["campsitePrice"]) . "</td>";
                        echo "<td>";
                        // Provide update and delete links for each campsite
                        echo "<a href='campsiteEdit.php?id=" . urlencode($row["campsiteID"]) . "'>Update</a> | ";
                        echo "<a href='campsiteDelete.php?id=" . urlencode($row["campsiteID"]) . "' onclick='return confirm(\"Are you sure you want to delete this campsite?\");'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<p>Row Count: $rowcount</p>";
                } else {
                    // Display a message if no campsites are found
                    echo "<p>No campsites found.</p>";
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            ?>
        </div>
    </div>
    <!-- Dropdown Content JS -->
    <script src="../../includes/adminAuth.js"></script>
</body>
</html>
