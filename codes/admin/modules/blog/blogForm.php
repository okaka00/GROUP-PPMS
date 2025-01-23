<?php
include("../../config/config.php");

// Fetch admin users from the database
$sql = "SELECT userID, userName FROM user WHERE roleID = 1"; // Assuming roleID = 1 corresponds to admin
$result = mysqli_query($conn, $sql);
$adminUsers = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $adminUsers[] = $row; // Add each admin user to the array
    }
} else {
    echo "Error fetching admin users: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Blog Form</title>
</head>

<body>
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <?php
    include '../../includes/sideNav.php';
    ?>

    <div class="main">
        <h2 style="text-align: center;">Blog Form</h2>
        <div class="rowform">
            <form action="insertBlog.php" method="POST" enctype="multipart/form-data">
                <label for="blogTitle">Blog Title:</label><br>
                <input type="text" id="blogTitle" name="blogTitle" required><br><br>

                <label for="blogEntry">Blog Entry:</label><br>
                <textarea id="blogEntry" name="blogEntry" rows="4" cols="50" required></textarea><br><br>

                <!-- Blog Image -->
                <label for="blogImg">Blog Image:</label><br>
                <input type="file" id="blogImg" name="blogImg" accept="image/*" required><br><br>

                <label for="createdBy">Created By:</label><br>
                <select id="createdBy" name="createdBy" required>
                    <option value="" disabled selected>Select Admin</option>
                    <?php foreach ($adminUsers as $admin) { ?>
                        <option value="<?php echo $admin['userID']; ?>">
                            <?php echo $admin['userName']; ?>
                        </option>
                    <?php } ?>
                </select><br><br>

                <label for="updatedDate">Updated Date:</label><br>
                <input type="date" id="updatedDate" name="updatedDate" required><br><br>

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
