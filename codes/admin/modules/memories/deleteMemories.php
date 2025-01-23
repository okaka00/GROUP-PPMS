<?php
//include db config
include("../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $memoriesID = intval($_GET['id']);
    // Delete the memories record
    $sql = "DELETE FROM memories WHERE memoriesID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $memoriesID);

    if (mysqli_stmt_execute($stmt)) {
        echo "memories Id $memoriesID deleted successfully!";
        echo "<br><a href='" . ADMIN_BASE_URL . "'>Back to Admin Panel</a>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>