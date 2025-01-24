<?php
// reviewProcess.php
session_start();
include("config/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if userID is set in the session
    if (!isset($_SESSION['UID'])) {
        die("User  not logged in.");
    }

    $userID = $_SESSION['UID']; // Get the userID from the session
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $reviewImg = '';

    // Handle file upload
    if (isset($_FILES['reviewImg']) && $_FILES['reviewImg']['error'] == 0) {
        $targetDir = "uploads/";
        
        // Ensure the uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetFile = $targetDir . basename($_FILES["reviewImg"]["name"]);
        if (move_uploaded_file($_FILES["reviewImg"]["tmp_name"], $targetFile)) {
            $reviewImg = $targetFile;
        } else {
            echo "Error uploading file.";
            exit();
        }
    }

    // Prepare and execute the insert query
    $query = "INSERT INTO review (userID, rating, comment, reviewImg, reviewDate) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $userID, $rating, $comment, $reviewImg);
    
    if ($stmt->execute()) {
        header("Location: reviewSuccess.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
