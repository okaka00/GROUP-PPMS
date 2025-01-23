<?php
// Include db config
session_start();
include("config/config.php");

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["memoryImg"])) {
    $userID = $_SESSION["UID"]; // Assuming userID is stored in session after login
    $memoryDate = date("Y-m-d H:i:s");
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["memoryImg"]["name"]);
    $upload_ok = 1;

    // Check if image file is valid
    if (isset($_FILES["memoryImg"]["tmp_name"]) && !empty($_FILES["memoryImg"]["tmp_name"])) {
        $check = getimagesize($_FILES["memoryImg"]["tmp_name"]);
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

    // Handle memory deletion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteMemory"])) {
        $memoryID = intval($_POST["memoryID"]);
        $sql_get_file = "SELECT memoryImg FROM memories WHERE memoriesID = '$memoryID' AND userID = '{$_SESSION["UID"]}'";
        $result = mysqli_query($conn, $sql_get_file);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $file_path = $row["memoryImg"];

            // Delete from database
            $sql_delete = "DELETE FROM memories WHERE memoriesID = '$memoryID' AND userID = '{$_SESSION["UID"]}'";
            if (mysqli_query($conn, $sql_delete)) {
                // Delete file from server
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                echo "<script>alert('Memory deleted successfully!');</script>";
            } else {
                echo "Error deleting memory: " . mysqli_error($conn);
            }
        }
    }

    // Proceed only if all checks pass
    if ($upload_ok) {
        if (move_uploaded_file($_FILES["memoryImg"]["tmp_name"], $target_file)) {
            // Insert data into the memories table
            $sql_insert = "INSERT INTO memories (userID, memoryImg, memoryDate) VALUES ('$userID', '$target_file', '$memoryDate')";
            if (mysqli_query($conn, $sql_insert)) {
                echo "<script>alert('Memory uploaded successfully!');</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch memories from the database
$sql_memories = "SELECT memories.*, user.userName FROM memories INNER JOIN user ON memories.userID = user.userID ORDER BY memoryDate DESC";
$result = mysqli_query($conn, $sql_memories);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Photo Album</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            font-weight: 600;
            color: #333;
        }

        .upload-form {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-form h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
            color: #333;
        }

        .upload-btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }

        .upload-form input[type="file"] {
            width: 100%;
            margin-bottom: 15px;
        }

        /* Blog Container */
        .memory-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
        }

        /* Memory Card */
        .memory-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .memory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .memory-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .memory-meta {
            font-size: 0.9rem;
            color: #555;
            margin: 10px 0;
        }

        .upload-form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .upload-btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-btn:hover {
            background-color: #0056b3;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }

        .footer small {
            font-size: 0.85rem;
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
        include("userAuth/modalForm.php");
        ?>

        <main>
            <h2>Our Photo Album</h2>

            <!-- Upload Form -->
            <div class="upload-form">
                <h3>Upload Your Memory</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="memoryImg" accept="image/*" required>
                    <br><br>
                    <button type="submit" class="upload-btn">Upload</button>
                </form>
            </div>

            <!-- Memories Display -->
            <div class="memory-container">
                <?php
                if ($rowcount > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="memory-card">';
                        if (!empty($row['memoryImg'])) {
                            echo '<img src="' . htmlspecialchars($row['memoryImg']) . '" alt="Memory Image" class="memory-img">';
                        }
                        echo '<p class="memory-meta">Uploaded by: ' . htmlspecialchars($row['userName']) . ' | On: ' . date("d/m/Y", strtotime($row['memoryDate'])) . '</p>';
                        // Add delete button
                        if ($_SESSION["UID"] == $row["userID"]) {
                            echo '
                                <form action="" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this memory?\');">
                                    <input type="hidden" name="memoryID" value="' . $row["memoriesID"] . '">
                                    <button type="submit" name="deleteMemory" class="delete-btn">Delete</button>
                                </form>
                            ';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>No memories available at the moment.</p>';
                }
                ?>
            </div>
        </main>
    </div>

    <footer class="footer">
        <p><small><i>Copyright &copy; 2025 FCI</i></small></p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll(".topnav a");
            const currentPath = window.location.pathname;

            navLinks.forEach(link => {
                if (link.href.includes(currentPath)) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        });

        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>
</body>

</html>
