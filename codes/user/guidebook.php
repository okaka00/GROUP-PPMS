<?php
// Include database configuration
$config_path = "config/config.php";
if (!file_exists($config_path)) {
    die("Error: Configuration file not found.");
}
include($config_path);

// Ensure database connection is established
if (!$conn) {
    die("Error: Database connection failed.");
}

// Fetch guidebooks from the database
$sql = "SELECT g.guidebookID, g.guidebookURL, g.guideDesc, g.guidebookImg, g.createdDate, u.userName
        FROM guidebook g
        JOIN user u ON g.userID = u.userID
        ORDER BY g.createdDate DESC";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error: Query failed - " . mysqli_error($conn));
}
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <title>Guidebooks</title>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            margin: 0;
            background-color: #F6F2F1;
            color: #08332C;
        }
        .topNav {
            background-color: #08332C;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }
        .topNav img {
            height: 40px;
        }
        .main {
            margin: 20px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }
        .main h2 {
            text-align: center;
            color: #08332C;
        }
        .guidebook-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .guidebook-item {
            background-color: #F6F2F1;
            border: 1px solid #C2AC7D;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.1);
        }
        .guidebook-item img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .guidebook-item h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #08332C;
        }
        .guidebook-item p {
            font-size: 14px;
            margin: 5px 0;
            color: #08332C;
        }
        .guidebook-item a {
            text-decoration: none;
            background-color: #08332C;
            color: #F6F2F1;
            padding: 10px 15px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
            font-size: 14px;
        }
        .guidebook-item a:hover {
            background-color: #C2AC7D;
            color: #08332C;
        }
    </style>
</head>
<body>
    <!-- User Navigation -->
    <?php include("includes/userNav.php"); ?>

    <!-- Main container for sticky footer -->
    <div class="container">
    <?php
         include("includes/topNav.php");
    ?>

    <div class="main">
        <h2>Available Guidebooks</h2>
        <div class="guidebook-list">
            <?php
            if ($rowcount > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='guidebook-item'>";
                    if ($row["guidebookImg"]) {
                        echo "<img src='" . htmlspecialchars($row["guidebookImg"]) . "' alt='Guidebook: " . htmlspecialchars($row["guidebookURL"]) . "'>";
                    }
                    echo "<h3>" . htmlspecialchars($row["guidebookURL"]) . "</h3>";
                    echo "<p>" . htmlspecialchars($row["guideDesc"]) . "</p>";
                    echo "<p><strong>Created by:</strong> " . htmlspecialchars($row["userName"]) . "</p>";
                    echo "<p><strong>Created on:</strong> " . htmlspecialchars($row["createdDate"]) . "</p>";
                    echo "<a href='" . htmlspecialchars($row["guidebookURL"]) . "' target='_blank' download>Download Guidebook</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No guidebooks available at the moment.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
