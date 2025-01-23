<?php
// Include db config
include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Manage About Members</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php
    include '../../includes/sideNav.php';
    ?>

    <div class="main">
        <h2 style="text-align: center;">Manage About Members List</h2>
        <div class="rowform">
            <?php
            $sql_members = "SELECT am.memberID, am.memberName, am.memberDesc, am.memberImg, am.userID, u.userName
            FROM aboutMembers am
            JOIN user u ON am.userID = u.userID
            ORDER BY am.memberID ASC";
            $result = mysqli_query($conn, $sql_members);
            $rowcount = mysqli_num_rows($result);

            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Member Name</th>";
                echo "<th>Description</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create html table row based on output data of each row from aboutMembers table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["memberName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["memberDesc"]) . "</td>";
                    echo "<td>";
                    echo "<a href='aboutMembersEdit.php?id=" . urlencode($row["memberID"]) . "'>Edit</a> | ";
                    echo "<a href='aboutMembersDelete.php?id=" . urlencode($row["memberID"]) . "' onclick='return confirm(\"Are you sure you want to delete this member?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                // Display row count
                echo "<p>Row Count: $rowcount</p>";
            } else {
                echo "<p>No results found.</p>";
            }

            // Free result set and close connection
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
    <p><a href="<?php echo ADMIN_BASE_URL; ?>">Admin Page</a></p>
</body>

</html>