<?php
//include db config
include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Memories List</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">

    </div>

    <?php
    include '../../includes/sideNav.php';
    ?>

    <div class="main">
        <h2 style="text-align: center;">Manage Memories List</h2>
        <div class="rowform">
            <?php
            $sql_memories = "SELECT m.memoriesID, m.userID, m.memoryImg, m.memoryDate, u.userID, u.userName
            FROM memories m, user u
            WHERE m.userID = u.userID
            ORDER BY memoryDate ASC";
            $result = mysqli_query($conn, $sql_memories);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Memories ID</th>";
                echo "<th>User </th>";
                echo "<th>Image</th>";
                echo "<th>memoryDate</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create html table row based on output data of each row from customer table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["memoriesID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
                    echo "<td><img src='../../img/" . htmlspecialchars($row['memoryImg']) . "' alt='Memories Image' width='50' height='50'></td>";
                    echo "<td>" . htmlspecialchars($row["memoryDate"]) . "</td>";
                    echo "<td>";
                    echo "<a href='deleteMemories.php?id=" . urlencode($row["memoriesID"]) . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                // Display row and field counts
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }

            echo '</div>';
            echo '</div>';
            // Free result set
            mysqli_free_result($result);
            //close connection
            mysqli_close($conn);
            ?>
            <p><a href="<?php echo ADMIN_BASE_URL; ?>">Admin Page</a></p>
