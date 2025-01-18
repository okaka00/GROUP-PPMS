<?php
// Include db config
session_start();
include("config/config.php");

// Fetch blog posts from the database
$sql_blog = "SELECT * FROM blog ORDER BY blogID DESC";
$result = mysqli_query($conn, $sql_blog);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/newstyle.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>

    /* Blog Container */
    .blog-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    /* Blog Post */
    .blog-post {
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      padding: 20px;
    }

    .blog-post:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .blog-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .blog-title {
      font-size: 1.75rem;
      margin-bottom: 15px;
      color: #34495e;
    }

    .blog-meta {
      font-size: 0.9rem;
      color: #7f8c8d;
      margin-bottom: 15px;
    }

    .blog-content {
      font-size: 1rem;
      line-height: 1.6;
      color: #2c3e50;
      margin-bottom: 15px;
    }

    .read-more {
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
      transition: color 0.3s;
    }

    .read-more:hover {
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
      <h2>Our Blog</h2>
      <div class="blog-container">
        <?php
        if ($rowcount > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="blog-post">';
            if (!empty($row['blogImg'])) {
              echo '<img src="' . htmlspecialchars($row['blogImg']) . '" alt="Blog Image" class="blog-img">';
            }
            echo '<h3 class="blog-title">' . htmlspecialchars($row['blogTitle']) . '</h3>';
            echo '<p class="blog-meta">Created by: ' . htmlspecialchars($row['createdBy']) . ' | Posted on ' . date("d/m/Y", strtotime($row['updatedDate'])) . '</p>';
            echo '<p class="blog-content">' . nl2br(htmlspecialchars($row['blogEntry'])) . '</p>';
            echo '<a href="blogDetails.php?id=' . $row['blogID'] . '" class="read-more">Read More</a>';
            echo '</div>';
          }
        } else {
          echo '<p>No blog posts available at the moment.</p>';
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