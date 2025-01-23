<?php
//include db config
include("../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    $categoryDesc = $_POST['categoryDesc'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $categoryDesc = mysqli_real_escape_string($conn, $_POST['categoryDesc']);

    $sql_insert = "INSERT INTO toolCategory (categoryName, categoryDesc) VALUES ('$categoryName', '$categoryDesc')";

    if (mysqli_query($conn, $sql_insert)) {
        echo "Category added successfully.";
        echo "<br><a href='" . ADMIN_BASE_URL . "'>Back to Admin Panel</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
