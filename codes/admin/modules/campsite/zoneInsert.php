<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    // Check if the form submission method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the Zone ID and Description from the form submission
        $zoneID = $_POST['zoneID'];
        $zoneDesc = $_POST['zoneDesc'];

        // Define the directories for file storage
        $target_dir = "../../../uploads/"; // Physical directory path
        $target_path = "uploads/";        // Path relative to the application
        $target_file = $target_dir . basename($_FILES["zoneImg"]["name"]); // Full physical path
        $target_fileDB = $target_path . basename($_FILES["zoneImg"]["name"]); // Path for database storage
        $upload_ok = 1; // Flag to track if the file is valid for upload

        // Check if the uploaded file is an actual image
        $check = getimagesize($_FILES["zoneImg"]["tmp_name"]);
        if ($check !== false) {
            // File is an image
            $upload_ok = 1;
        } else {
            // File is not an image
            echo "File is not an image.";
            $upload_ok = 0;
        }

        // Proceed with file upload if it passed the checks
        if ($upload_ok && move_uploaded_file($_FILES["zoneImg"]["tmp_name"], $target_file)) {
            // SQL query to insert a new record into the `zone` table
            $sql = "INSERT INTO zone (zoneID, zoneDesc, zoneImg)
                    VALUES ('$zoneID', '$zoneDesc', '$target_fileDB')";

            if (mysqli_query($conn, $sql)) {
                // Display success message and redirect the user
                echo "<script>
                        alert('New Zone Created!');
                        window.location.href = 'zoneForm.php';
                    </script>";
            } else {
                // Display SQL error if the query fails
                echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            // Display an error message if the file upload fails
            echo "Sorry, there was an error uploading your file. Error code: " . $_FILES["zoneImg"]["error"];
        }
    }

    // Close the database connection
    mysqli_close($conn);
?>
