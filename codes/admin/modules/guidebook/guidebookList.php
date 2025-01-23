<?php
// Include database configuration
include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Guidebook List</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Manage Guidebooks</h2>
        <div class="rowform">
            <?php
            $sql_guidebook = "SELECT g.guidebookID, g.guidebookURL, g.guideDesc, g.guidebookImg, g.createdDate, g.updatedDate, u.userName
            FROM guidebook g
            JOIN user u ON g.userID = u.userID
            ORDER BY g.createdDate DESC";
            $result = mysqli_query($conn, $sql_guidebook);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Guidebook ID</th>";
                echo "<th>Created By</th>";
                echo "<th>Guidebook URL</th>";
                echo "<th>Guidebook Description</th>";
                echo "<th>Guidebook Image</th>";
                echo "<th>Created Date</th>";
                echo "<th>Updated Date</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["guidebookID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row["guidebookURL"]) . "' target='_blank'>View Guidebook</a></td>";
                    echo "<td>" . htmlspecialchars($row["guideDesc"]) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row["guidebookImg"]) . "' style='width:50px;height:50px;'></td>";
                    echo "<td>" . htmlspecialchars($row["createdDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["updatedDate"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editGuidebook.php?id=" . urlencode($row["guidebookID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteGuidebook.php?id=" . urlencode($row["guidebookID"]) . "' onclick='return confirm(\"Are you sure you want to delete this guidebook?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }

            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
            <p><a href="<?php echo ADMIN_BASE_URL; ?>">Back to Admin Page</a></p>
        </div>
    </div>
</body>
</html>
