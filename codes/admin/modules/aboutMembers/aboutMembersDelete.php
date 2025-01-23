<?php
// Include database configuration
include("../../config/config.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $memberID = intval($_GET['id']);
    
    // Fetch the existing member data to get the image path
    $sql = "SELECT memberImg FROM aboutMembers WHERE memberID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $memberID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $memberImg = $row['memberImg'];
    } else {
        die("Member not found.");
    }
    mysqli_stmt_close($stmt);

    // Delete the member record
    $sql = "DELETE FROM aboutMembers WHERE memberID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $memberID);

    if (mysqli_stmt_execute($stmt)) {
        // Delete the image file if it exists
        if ($memberImg && file_exists("../../../" . $memberImg)) {
            unlink("../../../" . $memberImg);
        }
        echo "Member ID $memberID deleted successfully!";
        echo "<br><a href='aboutMembersList.php'>Back to About Members List</a>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>