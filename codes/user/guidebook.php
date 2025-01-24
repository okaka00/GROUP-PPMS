<?php
// Include db config
session_start();
include("config/config.php");

// Fetch guidebook entries from the database
$sql_guidebook = "SELECT * FROM guidebook ORDER BY guidebookID DESC";
$result = mysqli_query($conn, $sql_guidebook);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Guidebook</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/newstyle.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    /* Guidebook Container */
    .guidebook-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    /* Guidebook Post */
    .guidebook-post {
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      padding: 20px;
    }

    .guidebook-post:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .guidebook-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .guidebook-title {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #34495e;
    }

    .guidebook-meta {
      font-size: 0.9rem;
      color: #7f8c8d;
      margin-bottom: 15px;
    }

    .guidebook-desc {
      font-size: 1rem;
      line-height: 1.6;
      color: #2c3e50;
      margin-bottom: 15px;
    }

    .view-guide {
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
      transition: color 0.3s;
    }

    .view-guide:hover {
      color: #0056b3;
    }

    /* Footer */
    .footer {
      background-color: #2c3e50;
      color: #fff;
      text-align: center;
      padding: 15px;
      margin-top: 30px;
    }

    .footer small {
      font-size: 0.85rem;
    }
  </style>
</head>

<body>
  <!-- User Navigation -->
  <?php include("includes/userNav.php"); ?>

  <!-- Main container for sticky footer -->
  <div class="container">
    <?php
    include("includes/topNav.php");
    include("userAuth/modalForm.php");
    ?>

    <main>
      <h2>Our Guidebooks</h2>
      <div class="guidebook-container">
        <?php
        if ($rowcount > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="guidebook-post">';
            if (!empty($row['guidebookImg'])) {
              echo '<img src="' . htmlspecialchars($row['guidebookImg']) . '" alt="Guidebook Image" class="guidebook-img">';
            }
            echo '<h3 class="guidebook-title">Guidebook #' . htmlspecialchars($row['guidebookID']) . '</h3>';
            echo '<p class="guidebook-meta">Posted by User ID: ' . htmlspecialchars($row['userID']) . ' | Updated on ' . date("d/m/Y", strtotime($row['updatedDate'])) . '</p>';
            echo '<p class="guidebook-desc">' . nl2br(htmlspecialchars($row['guideDesc'])) . '</p>';
            if (!empty($row['guidebookURL'])) {
              echo '<a href="' . htmlspecialchars($row['guidebookURL']) . '" target="_blank" class="view-guide">View Guidebook</a>';
            }
            echo '</div>';
          }
        } else {
          echo '<p>No guidebooks available at the moment.</p>';
        }
        ?>
      </div>
    </main>
  </div>

  <footer class="footer">
    <p><small><i>Copyright &copy; 2024 FCI</i></small></p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navLinks = document.querySelectorAll(".topnav a");
      const currentPath = window.location.pathname;

      navLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
          link.classList.add("active");
        } else {
          link.classList.remove("active");
        }
      });
    });

    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }
  </script>
</body>

</html>
