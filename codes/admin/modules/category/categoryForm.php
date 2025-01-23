<?php
include("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Category Form</title>
    <style>
        /* Styling for the main content area */
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

        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .rowform input {
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
    <!-- Top navigation bar with a logo -->
    <?php
        include '../../includes/sideNav.php';
    ?>

    <?php
        include '../../includes/topNav.php';
    ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Category Form</h2>
        <div class="rowform">
            <!-- Form to add a new category -->
            <form action="insertCategory.php" method="POST" enctype="multipart/form-data">
                <!-- Category Name -->
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" placeholder="Enter Category Name" required>

                <!-- Category Description -->
                <label for="categoryDesc">Category Description:</label>
                <input type="text" id="categoryDesc" name="categoryDesc" placeholder="Enter Category Description" required>

                <!-- Submit Button -->
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        /* Toggle visibility of dropdown content in side navigation */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
            });
        }
    </script>
</body>

</html>

<?php
// Close the database connection if needed
// mysqli_close($conn); Uncomment if necessary.
?>

</html>
