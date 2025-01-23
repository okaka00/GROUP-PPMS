<?php include("config/config.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
    </head>
    <body>
        
        <?php
            include 'includes/sideNav.php'; 
        ?>
        
        <?php
            include 'includes/topNav.php'; 
        ?>


        <div class="main">
            <h2>Admin Panel Dashboard</h2>
            <p>                 Welcome to the dashboard. Here you can manage various settings and options.</p>
        </div>
        
        <script src="includes/adminAuth.js"></script>
    </body>
</html>
