<?php
// reviewSuccess.php
session_start();
include("config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Review Submitted</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
</head>
<body>
    <?php include("includes/userNav.php"); ?>
    <?php include("includes/topNav.php"); ?>

    <div class="container">
        <h1>Thank You!</h1>
        <p>Your review has been submitted successfully.</p>
        <a href="review.php">View Reviews</a>
    </div>
</body>
</html>