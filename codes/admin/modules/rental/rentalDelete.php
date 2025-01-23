<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
        $rentalID = mysqli_real_escape_string($conn, $_GET['id']);
    
        // Prepare the SQL statement to delete a record from the 'rental' table where the rentalID matches
        $sql = "DELETE FROM rental WHERE rentalID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind the rentalID parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $rentalID);
    
        if (mysqli_stmt_execute($stmt)) {
            // If the delete operation is successful, display an alert and redirect to the rental list page
            echo "<script>
                    alert('Deleted Successfully!');
                    window.location.href = 'rentalList.php';
                    </script>";
        } else {
            // If an error occurs, display the error message
            echo "Error deleting record: " . mysqli_error($conn);
        }
        // Close the prepared statement to free resources
        mysqli_stmt_close($stmt);
    } else {
        // If the request is invalid (not a GET request or 'id' not set), display an error message
        echo "Invalid request.";
    }
    // Close the database connection
    mysqli_close($conn);
?>
