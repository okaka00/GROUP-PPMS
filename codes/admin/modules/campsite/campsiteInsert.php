<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    include("../../config/config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data submitted by the user
        $zoneID = $_POST['zoneID']; // Zone ID selected by the user
        $campsiteID = $_POST['campsiteID']; // Campsite ID entered by the user
        $campsitePrice = $_POST['campsitePrice']; // Campsite price entered by the user

        // SQL query to insert a new campsite into the database
        $sql = "INSERT INTO campsite (zoneID, campsiteID, campsitePrice)
                VALUES ('$zoneID', '$campsiteID', '$campsitePrice')";

        // Execute the query and check if it was successful
        if (mysqli_query($conn, $sql)) {
            // Display a success message and redirect the user to the form page
            echo "<script>
                    alert('New Campsite Created!');
                    window.location.href = 'campsiteForm.php';
                </script>";
        } else {
            // Display an error message if the query fails
            echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
?>
