<nav class="topnav" id="myTopnav">

    <a href="index.php">Home</a>
    <a href="memories.php">Memories</a>
    <a href="campsites.php">Campsites</a>
    <a href="About_Our_Member.php">Our Member</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i></a>
        
        
        <?php if (isset($_SESSION["UID"])) { ?>
            
            <a href="tools_rental.php">Tools Rental</a>
            <a href="bookings.php">Bookings</a>
            <a href="guidebook.php">Guidebook</a>
            <a href="blog.php">Blog</a>
            <a href="review.php">Reviews</a>
    <?php }?>

    
</nav>

