<?php
include("../../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>About Members Form</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
        <a href="login.php">
            <i class="fa fa-sign-in" style="font: size 12px;"></i> Login
        </a>
    </div>

    <?php
    include '../../includes/sideNav.php';
    ?>

    <div class="main">
        <h2 style="text-align: center;">About Members Form</h2>
        <div class="rowform">
            <form action="aboutMembersInsert.php" method="POST" enctype="multipart/form-data">
                <label for="userID">User  ID:</label><br>
                <input type="number" id="userID" name="userID" required><br><br>

                <label for="memberName">Member Name:</label><br>
                <input type="text" id="memberName" name="memberName" required><br><br>

                <label for="memberDesc">Member Description:</label><br>
                <textarea id="memberDesc" name="memberDesc" rows="4" cols="50" required></textarea><br><br>

                <label for="memberImg">Member Image:</label><br>
                <input type="file" id="memberImg" name="memberImg" accept="image/*" required><br><br>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
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