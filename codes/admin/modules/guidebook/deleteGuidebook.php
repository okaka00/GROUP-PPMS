<?php
// Include database configuration
include("../../config/config.php");

if (isset($_GET['id'])) {
    $guidebookID = intval($_GET['id']);

    $sql = "SELECT guidebookImg FROM guidebook WHERE guidebookID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $guidebookID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $guidebook = mysqli_fetch_assoc($result);

    if ($guidebook) {
        $imagePath = "../../../" . $guidebook['guidebookImg'];
        $sql = "DELETE FROM guidebook WHERE guidebookID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $guidebookID);

        if (mysqli_stmt_execute($stmt)) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            echo "Guidebook deleted successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Guidebook not found.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}
mysqli_close($conn);

header("Location: guidebookList.php");
exit;
?>
