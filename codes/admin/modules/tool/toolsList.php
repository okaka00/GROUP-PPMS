<?php
// Include database configuration
include("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Tools List</title>
    <style>
        /* Styling for the main content area */
        .main {
            padding: 30px;
        }

        /* Styling for the form container */
        .rowform {
            width: 90%;
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

        th,
        td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd; 
        }

        th {
            background-color:rgb(0, 0, 0);
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: gray;
        }
    </style>
</head>

<body>

    <?php
        include '../../includes/sideNav.php';
    ?>
    
    <?php
        include '../../includes/topNav.php';
    ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Manage Tools</h2>
        <div class="rowform">
            <?php
            // SQL query to fetch tool and category data
            $sql_tool = "SELECT t.toolID, t.toolName, t.toolDesc, t.toolImg, t.pricePerDay, c.categoryName
                         FROM tool t
                         JOIN toolCategory c ON t.categoryID = c.categoryID
                         ORDER BY t.toolID ASC";
            $result = mysqli_query($conn, $sql_tool);

            // Check if rows exist
            if (mysqli_num_rows($result) > 0) {
                // Display the table header
                echo "<table>";
                echo "<tr>
                        <th>Tool ID</th>
                        <th>Tool Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Price (per day)</th>
                        <th>Actions</th>
                      </tr>";

                // Display table rows dynamically
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['toolID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['toolName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['toolDesc']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
                    echo "<td><img src='../../img/" . htmlspecialchars($row['toolImg']) . "' alt='Tool Image' width='50' height='50'></td>";
                    echo "<td>RM " . number_format($row['pricePerDay'], 2) . "</td>";
                    echo "<td>
                            <a href='editTools.php?id=" . urlencode($row['toolID']) . "'>Edit</a> | 
                            <a href='deleteTools.php?id=" . urlencode($row['toolID']) . "' onclick='return confirm(\"Are you sure you want to delete this tool?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";

                // Display row count
                echo "<p style='text-align: center;'>Total Tools: " . mysqli_num_rows($result) . "</p>";
            } else {
                echo "<p style='text-align: center;'>No tools found.</p>";
            }

            // Free result set and close connection
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
            <p style="text-align: center;"><a href="<?php echo ADMIN_BASE_URL; ?>">Back to Admin Page</a></p>
        </div>
    </div>

    <script>
        /* Toggle visibility of dropdown content in side navigation */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
            });
        }
    </script>
</body>

</html>
