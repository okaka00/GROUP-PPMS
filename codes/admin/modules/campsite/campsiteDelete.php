<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    // Check if the request method is GET and the 'id' parameter is set in the URL
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
        // Retrieve the 'id' parameter and convert it to an integer to prevent SQL injection
        $campsiteID = intval($_GET['id']);

        // Prepare the SQL statement to delete a record from the 'campsite' table based on campsiteID
        $sql = "DELETE FROM campsite WHERE campsiteID = ?";
        $stmt = mysqli_prepare($conn, $sql); // Prepare the statement
        mysqli_stmt_bind_param($stmt, "i", $campsiteID); // Bind the campsiteID to the statement
        
        // Execute the statement and check if the deletion was successful
        if (mysqli_stmt_execute($stmt)) {
            // If successful, display a success message and redirect to the campsite list page
            echo "<script>
            alert('Deleted Successfully!');
            window.location.href = 'campsiteList.php';
            </script>";
        } else {
            // If an error occurs during execution, display the error message
            echo "Error deleting record: " . mysqli_error($conn);
        }

        // Close the prepared statement to release resources
        mysqli_stmt_close($stmt);
    } else {
        // If the request method is not GET or 'id' is not provided, display an invalid request message
        echo "Invalid request.";
    }

    // Close the database connection to release resources
    mysqli_close($conn);
?>
