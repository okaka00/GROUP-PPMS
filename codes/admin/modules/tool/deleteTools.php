<?php
//include db config
include("../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $toolID = intval($_GET['id']);
    // Delete the tool record
    $sql = "DELETE FROM tool WHERE toolID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $toolID);

    if (mysqli_stmt_execute($stmt)) {
        echo "Tool Id $toolID deleted successfully!";
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