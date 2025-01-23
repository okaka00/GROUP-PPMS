<?php
// Include db config
include("../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $blogID = intval($_GET['id']);
    // Delete the blog record
    $sql = "DELETE FROM blog WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div style='background-color: #F6F2F1; color: #08332C; padding: 20px; border-radius: 8px;'>";
        echo "<h2 style='font-family: Arial, sans-serif; color: #C2AC7D;'>Blog Deleted Successfully</h2>";
        echo "<p style='font-family: Arial, sans-serif;'>Blog with ID <strong>$blogID</strong> has been deleted successfully.</p>";
        echo "<a href='" . ADMIN_BASE_URL . "' style='color: #C2AC7D; text-decoration: none; font-family: Arial, sans-serif;'>Back to Admin Panel</a>";
        echo "</div>";
    } else {
        echo "<div style='background-color: #F6F2F1; color: #08332C; padding: 20px; border-radius: 8px;'>";
        echo "<h2 style='font-family: Arial, sans-serif; color: #C2AC7D;'>Error</h2>";
        echo "<p style='font-family: Arial, sans-serif;'>There was an issue deleting the blog. Please try again later.</p>";
        echo "<a href='" . ADMIN_BASE_URL . "' style='color: #C2AC7D; text-decoration: none; font-family: Arial, sans-serif;'>Back to Admin Panel</a>";
        echo "</div>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<div style='background-color: #F6F2F1; color: #08332C; padding: 20px; border-radius: 8px;'>";
    echo "<h2 style='font-family: Arial, sans-serif; color: #C2AC7D;'>Invalid Request</h2>";
    echo "<p style='font-family: Arial, sans-serif;'>The request is invalid or missing necessary parameters. Please check the URL and try again.</p>";
    echo "</div>";
}

mysqli_close($conn);
?>
