<div class="topNav">
        <img src="<?php echo ADMIN_BASE_URL; ?>/img/icon.png" alt="Logo">

        <!-- if user in the session-->
        <?php if (isset($_SESSION["UID"])) { ?>
                <span>Welcome, <b><?php echo $_SESSION["userName"]; ?></b></span>
                <a href="<?php echo BASE_URL; ?>/userAuth/logout.php" ><i class="fa fa-sign-in" style="font: size 12px;"></i> Logout</a>
                
        <?php } else {  ?>
                        <!-- if no user in the session-->
                <a href="<?php echo BASE_URL; ?>" ><i class="fa fa-sign-in" style="font: size 12px;"></i>Login</a>
                        
        <?php }?>


    </div>

    
