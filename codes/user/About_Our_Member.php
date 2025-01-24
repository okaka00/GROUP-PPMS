<?php
// Include database configuration
session_start();
include("config/config.php");

// Fetch all members from the aboutMembers table
$sql = "SELECT * FROM aboutMembers";
$result = mysqli_query($conn, $sql);
$members = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $members[] = $row;
    }
} else {
    die("Error fetching members: " . mysqli_error($conn));
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>About Our Members</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<!-- User Nav section-->
<?php include("includes/userNav.php"); ?>

<!-- Main container for sticky footer -->
<div class="container">
    <!-- Navigation Menu -->
    <?php include("includes/topNav.php"); ?>

    <!-- About Our Members Section -->
    <div class="main">
        <h1>About Our Members</h1>
        <div class="row">
            <?php foreach ($members as $member): ?>
                <div class="column">
                    <div class="member-content"> <!-- Updated class name -->
                        <div class="profile-image">
                            <img src="<?= htmlspecialchars($member['memberImg']) ?>" alt="<?= htmlspecialchars($member['memberName']) ?>">
                        </div>
                        <h3><?= htmlspecialchars($member['memberName']) ?></h3>
                        <p><?= htmlspecialchars($member['memberDesc']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Copyright &copy; 2024 Mini Café. All rights reserved.</p>
    </footer>
</div>

<script>
    //JS function called on small screen
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }

    //menu navigation active, upon page load
    document.addEventListener("DOMContentLoaded", function () {
        const navLinks = document.querySelectorAll(".topnav a");
        const currentPath = window.location.pathname;

        // Remove any existing 'active' class from all links initially
        navLinks.forEach(link => link.classList.remove("active"));

        // Add 'active' class to the link that matches the current path
        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname; // Get path part of link's URL
            if (linkPath === currentPath) {
                link.classList.add("active");
            }
        });
    });
</script>

</body>
</html>
