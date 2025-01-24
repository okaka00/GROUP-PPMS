<!-- AFIQAH BINTI AHMAD FAIRUZE (BI22110327) -->

<?php
    session_start();
    include("../../config/config.php");

    // Query to fetch zone details (zoneID, zoneDesc, zoneImg) from the database
    $zonesQuery = "SELECT zoneID, zoneDesc, zoneImg FROM zone";
    // Execute the query and store the result
    $zonesResult = mysqli_query($conn, $zonesQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Campsite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <style>
        /* General styling for the main content area */
        .main {
            padding: 30px;
        }

        /* Styling for the form container */
        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Styling for the zone image preview */
        #zoneImgPreview {
            text-align: center;
            margin-bottom: 20px;
        }

        #zoneImgPreview img {
            width: 250px;
            height: 250px;
            object-fit: cover;
        }

        /* Styling for form labels */
        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Styling for form input and select elements */
        .rowform select,
        .rowform input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Styling for the submit button */
        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
        }

        button:hover {
            background-color: gray;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <?php include '../../includes/topNav.php'; ?>

    <!-- Side Navigation -->
    <?php include '../../includes/sideNav.php'; ?>

    <!-- Main Content -->
    <div class="main">
        <h2 style="text-align: center;">Create Campsite</h2>
        <div class="rowform">
            <!-- Form to add a new campsite -->
            <form action="campsiteInsert.php" method="POST">
                <!-- Zone image preview section -->
                <div id="zoneImgPreview">
                </div>

                <!-- Dropdown to select a zone -->
                <label for="zoneID">Select Zone:</label>
                <select id="zoneID" name="zoneID" onchange="showZoneImage()">
                    <option value="">Choose a Zone</option>
                    <?php
                        // Populate the dropdown with zones fetched from the database
                        if (mysqli_num_rows($zonesResult) > 0) {
                            while ($zone = mysqli_fetch_assoc($zonesResult)) {
                                // Use htmlspecialchars to prevent XSS attacks
                                echo "<option value='" . htmlspecialchars($zone['zoneID']) . "' data-img='" . htmlspecialchars($zone['zoneImg']) . "'>" . htmlspecialchars($zone['zoneID']) . "</option>";
                            }
                        } else {
                            // Display a message if no zones are available
                            echo "<option value=''>No Zones Available</option>";
                        }
                    ?>
                </select><br><br>

                <!-- Input for campsite ID -->
                <label for="campsiteID">Campsite ID:</label>
                <input type="text" id="campsiteID" name="campsiteID" placeholder="Enter Campsite ID" required><br><br>

                <!-- Input for campsite price -->
                <label for="campsitePrice">Price:</label>
                <input type="text" id="campsitePrice" name="campsitePrice" placeholder="Enter Campsite Price" required><br><br>

                <!-- Submit button -->
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // Function to show the image of the selected zone
        function showZoneImage() {
            var selectZone = document.getElementById('zoneID');
            var selectedOption = selectZone.options[selectZone.selectedIndex];
            var zoneImg = selectedOption.getAttribute('data-img');
            
            var imagePreview = document.getElementById('zoneImgPreview');

            // Display the image if available, otherwise clear the preview
            if (zoneImg) {
                imagePreview.innerHTML = "<img src='../../../" + zoneImg + "' alt='Zone Image'>";
            } else {
                imagePreview.innerHTML = "";
            }
        }
    </script>

    <!-- Dropdown Content JS -->
    <script src="../../includes/adminAuth.js"></script>

    <!-- Close the database connection -->
    <?php mysqli_close($conn); ?>
</body>
</html>
