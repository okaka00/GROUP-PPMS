
<?php
//include db config
session_start();
include("config/config.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Kokol Mamahill</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    h2, h3 {
        font-family: 'Roboto', sans-serif;
        color: #333;
    }

    p {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
    }

    /* Main Introduction Section */
    .main-introduction {
        padding: 10px;
        background: linear-gradient(135deg, #f9f9f9, #e4e6e8);
        text-align: center;
        border-bottom: 2px solid #ddd;
    }

    .intro-content h2 {
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .intro-content p {
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.1rem;
        color: #7f8c8d;
    }

    /* Highlights Section */
    .highlights {
        padding: 60px 20px;
        background-color: #fff;
        text-align: center;
    }

    .highlight-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .highlight-item {
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 30%;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .highlight-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .highlight-item h3 {
        font-size: 1.8rem;
        color: #34495e;
    }

    .highlight-item p {
        margin-top: 10px;
    }

    .highlight-image {
        width: 50%;
        margin: 10px auto;
        border-radius: 8px;
       
    }

	.Location-header{
		padding: 10px;
        background: linear-gradient(135deg, #f9f9f9, #e4e6e8);
        text-align: center;
        border-bottom: 2px solid #ddd;
		height: 40px;

	}

	.Location-box{
		background-color: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 200 px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;

	}


	@media screen and (max-width: 980px) {
		
	}

</style>
</head>
<body>

	<!-- User Nav section-->
	<?php
	include("includes/userNav.php");
	?>
	
	<!-- Main container for sticky footer -->
	<div class="container">
		<!-- Navigation Menu -->
		<?php
		include("includes/topNav.php");
		?>

		<!-- Login Popup -->
		<?php
		include("userAuth/login.php");
		?>

		<!-- registration Popup -->
		<?php
		include("userAuth/register.php");
		?>

		<!-- Place banner under menu for bigger space -->
		<img class="image" src="img/banner.png">
	

		<!-- Introduction Section -->
		<section class="main-introduction">
			<div class="intro-content">
				<h2>Our Offerings</h2>
				<p>Mamahillcamp offers the perfect escape for outdoor enthusiasts and relaxation seekers. 
				With a beautiful riverside view and facilities to host ,
				 we ensure an unforgettable camping experience.</p>
			</div>
		</section>

		<!-- Highlights Section -->
		<section class="highlights">
			<div class="highlight-container">
				<div class="highlight-item">
					<h3>Our Signature</h3>
					<a href="campsites.php"><img src="img/index5.png" alt="camping" class="highlight-image"></a>
					<p>Campsite & Chalet</p>
				</div>

				<div class="highlight-item">
					<h3>Attraction</h3>
					<a href="photo_album.php"> <img src="img/index6.png" alt="activity" class="highlight-image"></a>
					<p>Explore our main activities!</p>
				</div>

				<div class="highlight-item">
					<h3>Event Space</h3>
					<a href="promotions_events.php"> <img src="img/index4.png" alt="Lounge Room" class="highlight-image"> </a>
					<p>A space for celebration by connecting with the nature.</p>
				</div>
			</div>
		</section>
		
		<!-- location Section -->
		<section class="galery-header">
		<div class="intro-content">
				<h2>Our Location</h2>
		</div>
		</section>

		<section class="highlights">
		<div class="row">
			<div class="col-left">
					<div style="width: 800px; height: 600px; margin: auto;">
						<iframe 
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.863409287196!2d116.20435933898426!3d6.013485428905886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x323b6d1a9ccd4cf9%3A0x128a167f42a6e048!2sKokol%20MamaHill%20Campsite!5e0!3m2!1sen!2smy!4v1737578865854!5m2!1sen!2smy"
							width="100%" 
							height="100%" 
							style="border:0;" 
							allowfullscreen="" 
							loading="lazy">
						</iframe>
					</div>
			</div>
			<div class="col-right">
				<div class="Location-box">
					<h2>Find Us Here At Kokol Hill</h2>
					<p> Mamahillcamp is located at Kokol Hill, 
						just a 30-minute drive from Kota Kinabalu city. 
						Enjoy breathtaking views, fresh mountain air, 
						and a peaceful escape in nature.
					</p>
				</div>
			</div>
				
		</div>
		</section>
		




	</div>

  <!-- Footer -->
  <footer>
    <p>Copyright &copy; 2024 Mini Café. All rights reserved.</p>
  </footer>

  <script src="includes/modalAuth.js">	</script>
</body>


</html>
