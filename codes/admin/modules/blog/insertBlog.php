<?php
// Include database configuration
include("../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogTitle = $_POST['blogTitle'] ?? '';
    $blogEntry = $_POST['blogEntry'] ?? '';
    $createdBy = $_POST['createdBy'] ?? '';
    $updatedDate = $_POST['updatedDate'] ?? date('Y-m-d'); // Fallback to the current date

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["blogImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["blogImg"]["name"]);
    $upload_ok = 1;

    if (isset($_FILES["blogImg"]) && $_FILES["blogImg"]["tmp_name"] !== "") {
        $check = getimagesize($_FILES["blogImg"]["tmp_name"]);
        if ($check !== false) {
            $upload_ok = 1;
        } else {
            echo "File is not an image.";
            $upload_ok = 0;
        }
    } else {
        echo "No image file uploaded.";
        $upload_ok = 0;
    }

    if ($upload_ok && move_uploaded_file($_FILES["blogImg"]["tmp_name"], $target_file)) {
        // Use prepared statements
        $sql = "INSERT INTO blog (blogTitle, blogEntry, blogImg, createdBy, updatedDate)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $blogTitle, $blogEntry, $target_fileDB, $createdBy, $updatedDate);

        if ($stmt->execute()) {
            // Display success message
            echo "<div class='success-message'>
                    <h2>Blog Posted Successfully!</h2>
                    <p>Your blog titled <strong>" . htmlspecialchars($blogTitle) . "</strong> has been successfully created.</p>
                    <div class='action-buttons'>
                        <a href='" . ADMIN_BASE_URL . "' class='btn'>Back to Admin Panel</a>
                    </div>
                </div>";
        } else {
            echo "<br>Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$conn->close();
?>

<!-- Add CSS for Styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #F6F2F1; /* Light background color */
        margin: 0;
        padding: 0;
    }

    .success-message {
        background-color: #C2AC7D; /* Soft gold background for success message */
        color: #08332C; /* Dark green text */
        padding: 30px;
        margin: 50px auto;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .success-message h2 {
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .success-message p {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .action-buttons {
        margin-top: 20px;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        margin: 10px;
        text-decoration: none;
        background-color: #08332C; /* Dark green background for buttons */
        color: #F6F2F1; /* Light text color */
        border-radius: 4px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #05562C; /* Darker green on hover */
    }

    .btn:active {
        background-color: #06392C; /* Even darker green when clicked */
    }

    .btn:focus {
        outline: none;
    }
</style>
