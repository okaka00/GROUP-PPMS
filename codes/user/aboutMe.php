<?php
//include db config
session_start();
include("config/config.php");
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
        /* Combined About Me and Personal Information Section Styling */
        .about-and-info {
            padding: 50px 20px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
        }

        .about-info-container {
            max-width: 1200px;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        /* About Me Styling */
        .about {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-image img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .about-content h2 {
            font-family: 'Raleway', sans-serif;
            color: #333;
            margin-bottom: 15px;
        }

        .about-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        /* Personal Information Styling */
        .personal-info {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .personal-info h2 {
            font-family: 'Raleway', sans-serif;
            margin-bottom: 20px;
            color: #333;
        }

        .info-table table {
            border-collapse: collapse;
            width: 100%;
            font-size: 16px;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .info-table th {
            background-color: #333;
            color: white;
        }

        .info-table td {
            background-color: #f9f9f9;
        }

        .info-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about-info-container {
                flex-direction: column;
            }

            .about,
            .personal-info {
                width: 100%;
            }
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

    <!-- About Me and Personal Information Section -->
    <section class="about-and-info">
        <div class="about-info-container">
            <!-- Personal Information Section -->
            <div class="personal-info">
                <h2>Personal Information</h2>
                <div class="profile-image">
                    <img src="img/profile.jpg" alt="Profile Picture">
                </div>
                <div class="info-table">
                    <table>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>Julia Natasha Binti Jemuin</td>
                        </tr>
                        <tr>
                            <td>Matric Number</td>
                            <td>BI22110410</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- About Me Section -->
            <div class="about">

                <div class="about-content">
                    <h2>About Me</h2>
                    <p>
                        Hi, I'm <strong>Julia Natasha Binti Jemuin</strong>, the proud owner of Mini Café.
                        My passion for coffee and food led me to create a space where everyone can unwind, connect, and
                        enjoy exceptional flavors.
                    </p>
                    <p>
                        When I'm not managing the café, I enjoy experimenting with recipes, exploring nature, and
                        staying updated with the latest coffee trends.
                        Creating a warm and welcoming environment is what inspires me every day.
                    </p>
                </div>
            </div>



        </div>
    </section>

    <!-- Mini Cafe Journey Section -->
    <section class="journey">
        <h3>My Mini Café Journey</h3>
        <div class="timeline">
            <!-- Timeline Item 1 -->
            <div class="timeline-item">
                <img src="img/idea.jpeg" alt="Idea Stage">
                <div class="content">
                    <h4>2018 - The Dream</h4>
                    <p>
                        It all started with a simple dream to create a space where people could enjoy coffee, relax, and
                        connect.
                    </p>
                </div>
            </div>
            <!-- Timeline Item 2 -->
            <div class="timeline-item">
                <img src="img/planning.jpeg" alt="Planning Stage">
                <div class="content">
                    <h4>2020 - Planning and Preparation</h4>
                    <p>
                        From sourcing ingredients to designing the perfect menu, every detail was carefully thought out.
                    </p>
                </div>
            </div>
            <!-- Timeline Item 3 -->
            <div class="timeline-item">
                <img src="img/opening.jpeg" alt="Opening Day">
                <div class="content">
                    <h4>2023 - Grand Opening</h4>
                    <p>
                        The doors of Mini Café opened to the community, bringing the vision to life.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>Copyright &copy; 2024 Mini Café. All rights reserved.</p>
    </footer>

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