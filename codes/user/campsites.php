<?php
//include db config
session_start();
include("config/config.php");

// Initialize cart session if not set
if (!isset($_SESSION['cart_item'])) {
    $_SESSION['cart_item'] = [];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Mini Cafe</title>
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
        width: 80%;
        max-width: 300px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Event Images */
    .event-images {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin: 20px 0;
    }

    .event-image {
        width: 23%;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Booking Button Styles */
.booking-button {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.booking-button:hover {
    background: linear-gradient(135deg, #45a049, #4CAF50);
    transform: translateY(-2px);
}

.booking-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

{
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .tool-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .tool-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
        }

        .tool-item img {
            width: 100%;
            border-radius: 8px;
        }

        .tool-item h3 {
            color: #34495e;
        }

        .tool-item p {
            color: #555;
        }

        .rent-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .rent-button:hover {
            background-color: #45a049;
        }
</style>
</head>

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
		<!-- Place banner under menu for bigger space -->
		<img class="image" src="img/banner.png">
	
		<!-- Login Popup -->
		<div id="login-popup" class="login-popup">
			<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
			<h3>User Login </h3>
			<form action="userAuth/login_action.php" method="post">
				<label for="userEmail">User Email:</label><br>
				<input type="email" id="userEmail" name="userEmail" required><br><br>
				<label for="userPwd">Password:</label><br>
				<input type="password" id="userPwd" name="userPwd" required maxlength="8" autocomplete="off"><br><br>
				<input type="submit" value="Login">
				<input type="reset" value="Reset"></br>
			</form>
			<p><a href="javascript:void(0);" onclick="openRegPopup();">| Registration </a> | Forgot Password |</p>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
		<!-- End Login Popup -->
		<!-- Registration Popup -->
		<div id="reg-popup" class="reg-popup">
			<span class="close-btn" onclick="closeRegPopup()">&times;</span>
			<h3>User Registration </h3>
			<form action="userAuth/register_action.php" method="post">
				<label for="reguserName">Username:</label><br>
				<input type="text" id="reguserName" name="userName" required><br><br>
				<label for="reguserEmail">User Email:</label><br>
				<input type="email" id="reguserEmail" name="userEmail" required><br><br>
				<label for="reguserPwd">Password:</label><br>
				<input type="password" id="reguserPwd" name="userPwd" required maxlength="8"><br><br>
				<label for="regconfirmPwd">Confirm Password:</label><br>
				<input type="password" id="regconfirmPwd" name="confirmPwd" required><br><br>
				<input type="submit" value="Register">
				<input type="reset" value="Reset"></br>
			</form>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
		<!-- End Registration Popup -->

           <!-- Display available campsites -->
           <section class="campsite-booking">
        <div class="main-introduction">
            <div class="intro-content">
                <h2>Book Your Perfect Campsite</h2>
                <p>Choose from a variety of beautiful campsites and enjoy your outdoor adventure!</p>
            </div>
        </div>
       
    <div class="highlights">
        <div class="highlight-container">
            <?php
            // Fetch campsites from the database
            $sql = "SELECT campsite.campsiteID, campsite.campsitePrice, zone.zoneID, zone.zoneImg, zone.zoneDesc
                    FROM campsite
                    JOIN zone ON campsite.zoneID = zone.zoneID"; // Join with the zone table
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                // Loop through each campsite and display it
                while ($row = mysqli_fetch_assoc($result)) {
                    $campsiteId = htmlspecialchars($row['campsiteID']);
                    $campsitePrice = htmlspecialchars($row['campsitePrice']);
                    $zoneImg = $row['zoneImg'];
                    $zoneDesc = htmlspecialchars($row['zoneDesc']);
            ?>
                    <div class="highlight-item">
                        <img src="<?= $zoneImg ?>" alt="<?= $zoneDesc ?>" class="highlight-image">
                        <h3>Campsite ID: <?= $campsiteId ?></h3>
                        <p>Zone Description: <?= $zoneDesc ?></p>
                        <p>Price: RM <span id="price-<?= $campsiteId ?>"><?= $campsitePrice ?></span>/day</p>
                        
                        <form method="post" action="cart_action.php?action=add&id=<?= $campsiteId ?>">  
                            <input type="hidden" id="product-quantity-<?= $campsiteId ?>" name="quantity" value="1">  
                            <button type="submit" class="booking-button">Add to Cart</button>  
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p>No campsites available at the moment.</p>';
            }
            ?>
        </div>
    </div>
</section>

    <!-- Footer -->
  <footer>
    <p>Copyright &copy; 2025 Mamahill Camp. All rights reserved.</p>
  </footer>

  <script>

    // Function to open the booking form
    function openBookingForm(campsiteID) {
            var container = document.getElementById('booking-form-container');
            container.style.display = 'block';
            // Change the action URL for the form based on the selected campsite
            var formAction = 'campsites.php?campsiteID=' + campsiteID;
            container.innerHTML = '<h2>Loading booking form...</h2>'; // Show loading text
            fetch(formAction)
                .then(response => response.text())
                .then(data => {
                    container.innerHTML = data; // Load form
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = '<p>Failed to load booking form. Please try again.</p>';
                });
        }

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
		document.addEventListener("DOMContentLoaded", function() {
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

		//Login & Reg Form Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

		function openRegPopup() {
			document.getElementById("reg-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeRegPopup() {
			document.getElementById("reg-popup").style.display = "none";
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}
	</script>

</body>


</html>
