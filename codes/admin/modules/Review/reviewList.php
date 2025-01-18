<?php
// Include db config
include("../../config/config.php");

// Fetch reviews based on 'cat' parameter, if available
$reviewID = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

if ($reviewID > 0) {
    $sql_review = "SELECT r.reviewID, r.reviewText, r.rating, r.productID, 
                          p.productName, r.reviewBy, u.userName, r.reviewDate
                   FROM review r
                   JOIN product p ON r.productID = p.productID
                   JOIN user u ON r.reviewBy = u.userID
                   WHERE r.reviewID = $reviewID
                   ORDER BY r.reviewID ASC";
} else {
    $sql_review = "SELECT r.reviewID, r.reviewText, r.rating, r.productID, 
                          p.productName, r.reviewBy, u.userName, r.reviewDate
                   FROM review r
                   JOIN product p ON r.productID = p.productID
                   JOIN user u ON r.reviewBy = u.userID
                   ORDER BY r.reviewID ASC";
}

$result = mysqli_query($conn, $sql_review);
$rowcount = ($result) ? mysqli_num_rows($result) : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Manage Review</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">

    </div>

    <?php include '../../includes/sideNav.php'; ?>

    <div class="main">
        <h2 style="text-align: center;">Manage Reviews</h2>
        <div class="rowform">
            <?php
            if ($rowcount > 0) {
                // Start the table
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Review ID</th>";
                echo "<th>Product Name</th>";
                echo "<th>Comment</th>";
                echo "<th>Rating</th>";
                echo "<th>Reviewed By</th>";
                echo "<th>Review Date</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                // Dynamically create HTML table rows based on review data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["reviewID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["productName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reviewText"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reviewDate"]) . "</td>";
                    echo "<td>";
                    echo "<a href='deleteReview.php?id=" . urlencode($row["reviewID"]) . "' onclick='return confirm(\"Are you sure you want to delete this review?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                // Display row count
                echo "<p>Total Reviews: $rowcount</p>";
            } else {
                echo "<p>No reviews found.</p>";
            }

            // Free result set and close connection
            if ($result) {
                mysqli_free_result($result);
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>

</html>