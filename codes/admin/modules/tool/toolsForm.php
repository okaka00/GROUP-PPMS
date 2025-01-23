<!-- JULIA NATASHA BINTI JEMUIN (BI22110410) -->

<?php
include("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Tools Form</title>
    <style>
        /* Styling for the form container */
        .main {
            padding: 30px;
        }

        /* Styling for the form elements */
        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .rowform input,
        .rowform select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: gray;
        }
    </style>
</head>

<body>
    <?php
        include '../../includes/sideNav.php';
    ?>

    <?php
        include '../../includes/topNav.php';
    ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Add New Tool Form</h2>
        <div class="rowform">
            <!-- Form to add a new tool -->
            <form action="insertTools.php" method="POST" enctype="multipart/form-data">

                <!-- Tool Name -->
                <label for="toolName">Tool Name:</label><br>
                <input type="text" id="toolName" name="toolName" required><br><br>

                <!-- Tool Description -->
                <label for="toolDesc">Tool Description:</label><br>
                <input type="text" id="toolDesc" name="toolDesc" required><br><br>

                <!-- Tool Rent Price -->
                <label for="pricePerDay">Tool Rent Price:</label><br>
                <input type="number" id="pricePerDay" name="pricePerDay" min="0.01" step="0.01" required><br><br>

                <!-- Tool Category -->
                <label for="categoryID">Tool Category:</label><br>
                <?php
                $sql = "SELECT categoryID, categoryName FROM toolCategory";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo "<select name='categoryID' id='categoryID' required>";
                    echo "<option value=''>Select Category</option>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['categoryID'] . "'>" . $row['categoryName'] . "</option>";
                    }
                    echo "</select>";
                } else {
                    echo "<p>No categories found. Please add a category first.</p>";
                }
                ?><br><br>

                <!-- Tool Image -->
                <label for="toolImg">Tool Image:</label><br>
                <input type="file" id="toolImg" name="toolImg" accept="image/*" required><br><br>

                <!-- Submit Button -->
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
</html>



