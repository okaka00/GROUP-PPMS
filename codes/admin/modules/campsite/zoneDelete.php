<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
        // Escape special characters in the provided ID to prevent SQL injection
        $zoneID = mysqli_real_escape_string($conn, $_GET['id']);

        // Prepare the SQL query to delete a record from the 'zone' table using a prepared statement
        $sql = "DELETE FROM zone WHERE zoneID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind the provided ID to the SQL query
        mysqli_stmt_bind_param($stmt, "s", $zoneID);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // If successful, display an alert and redirect to the 'zoneList.php' page
            echo "<script>
                    alert('Deleted Successfully!');
                    window.location.href = 'zoneList.php';
                </script>";
        } else {
            // Display an error message if the deletion fails
            echo "Error deleting record: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Display an error message for invalid requests
        echo "Invalid request.";
    }

    // Close the database connection
    mysqli_close($conn);
?>
