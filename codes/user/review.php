<?php
// Include database configuration
include("config/config.php");
session_start();


// Initialize variables for messages
$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $reviewBy = $_SESSION["UID"];
  $productID = $_POST["productID"];
  $reviewText = mysqli_real_escape_string($conn, $_POST["reviewText"]);
  $reviewDate = $_POST["reviewDate"];
  $rating = (int) $_POST["rating"];

  // Validate inputs
  if (empty($reviewBy) || empty($reviewText) || empty($reviewDate) || $rating < 1 || $rating > 5) {
    $errorMessage = "Please complete all fields with valid values.";
  } else {
    // Insert the review into the database
    $sql = "INSERT INTO review (reviewBy, productID, reviewText, rating, reviewDate) 
                VALUES ('$reviewBy', '$productID', '$reviewText', '$rating', '$reviewDate')";

    if (mysqli_query($conn, $sql)) {
      // Redirect to "My Order" page with a success message
      $_SESSION['reviewSuccess'] = "Thank you for submitting your review!";
      header("Location: my_order.php");
      exit;
    } else {
      $errorMessage = "Error submitting your review: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Submit Your Review</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/newstyle.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      color: #333;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 8px;
      color: #555;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
      box-sizing: border-box;
    }

    .form-group textarea {
      resize: vertical;
      height: 100px;
    }

    .form-group button {
      width: 100%;
      padding: 12px;
      background-color: #007BFF;
      color: #ffffff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-group button:hover {
      background-color: #0056b3;
    }

    .rating-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .rating-group input {
      width: auto;
    }

    .message {
      text-align: center;
      font-size: 1rem;
      font-weight: bold;
      margin-top: 20px;
    }

    .message.success {
      color: green;
    }

    .message.error {
      color: red;
    }

    footer {
      text-align: center;
      padding: 15px;
      margin-top: 30px;
      background-color: #2c3e50;
      color: #fff;
    }
  </style>
</head>

<body>
  <?php 
    include("includes/userNav.php");
    include("includes/topNav.php");

  // Check if user is logged in
  if (!isset($_SESSION["UID"])) {
    echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        openLoginPopup();
                    });
                </script>';
    exit;
  } else {
    $userID = $_SESSION["UID"];
  }
  ?>

  <div class="container">
    <h2>Submit Your Review</h2>

    <?php
    if (isset($_SESSION['reviewError'])) {
      echo "<p class='message error'>" . htmlspecialchars($_SESSION['reviewError']) . "</p>";
      unset($_SESSION['reviewError']);
    }
    ?>


    <form method="POST" action="">
      <div class="form-group">
        <label for="productID">Select a Product:</label>
        <select id="productID" name="productID" required>
          <option value="">-- Select Product --</option>
          <?php
          // Fetch product options from the database
          $sql_product = "SELECT productID, productName FROM product";
          $result_product = mysqli_query($conn, $sql_product);

          while ($row = mysqli_fetch_assoc($result_product)) {
            echo '<option value="' . htmlspecialchars($row["productID"]) . '">' . htmlspecialchars($row["productName"]) . '</option>';
          }

          mysqli_free_result($result_product);
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="reviewText">Review:</label>
        <textarea id="reviewText" name="reviewText" required></textarea>
      </div>

      <div class="form-group">
        <label for="reviewDate">Review Date:</label>
        <input type="date" id="reviewDate" name="reviewDate" required>
      </div>

      <div class="form-group">
        <label for="rating">Rating (1-5):</label>
        <div class="rating-group">
          <input type="range" name="rating" id="rating" min="1" max="5" value="0" oninput="ratingValue.innerText = this.value">
          <span id="ratingValue">0</span>
        </div>
      </div>

      <div class="form-group">
        <button type="submit">Submit Review</button>
      </div>
    </form>
  </div>

  <footer>
    <p>&copy; 2024 FCI</p>
  </footer>
</body>

</html>
