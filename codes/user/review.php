<?php
// review.php
session_start();
include("config/config.php");

// Fetch all reviews from the review table
$sql = "SELECT * FROM review ORDER BY reviewDate DESC";
$result = mysqli_query($conn, $sql);
$reviews = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
} else {
    die("Error fetching reviews: " . mysqli_error($conn));
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Reviews</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/newstyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include("includes/userNav.php"); ?>
    <?php include("includes/topNav.php"); ?>

    <div class="container">
        <h1>User Reviews</h1>
        
        <button id="writeReviewBtn">Write a Review!</button>

        <div id="reviews">
            <?php foreach ($reviews as $row): ?>
                <div class="review">
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star<?= ($i <= $row['rating']) ? '' : '-empty' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p><?= htmlspecialchars($row['comment']) ?></p>
                    <?php if ($row['reviewImg']): ?>
                        <img src="<?= htmlspecialchars($row['reviewImg']) ?>" alt="Review Image" />
                    <?php endif; ?>
                    <p><small><?= htmlspecialchars($row['reviewDate']) ?></small></p>
                    
                    <!-- Add delete button if the logged-in user is the owner of the review -->
                    <?php if (isset($_SESSION['UID']) && $_SESSION['UID'] == $row['userID']): ?>
                        <form action="deleteReview.php" method="POST" style="display:inline;">
                            <input type="hidden" name="reviewID" value="<?= $row['reviewID'] ?>">
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this review?');">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="reviewModal" style="display:none;">
        <form action="reviewProcess.php" method="POST" enctype="multipart/form-data">
            <h2>Write a Review</h2>
            <label for="rating">Rating:</label>
            <select name="rating" required>
                <option value="">Select Rating</option>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
            <label for="comment">Comment:</label>
            <textarea name="comment" required></textarea>
            <label for="reviewImg">Upload Image:</label>
            <input type="file" name="reviewImg" accept="image/*">
            <button type="submit">Submit Review</button>
            <button type="button" onclick="document.getElementById('reviewModal').style.display='none'">Cancel</button>
        </form>
    </div>

    <script>
        document.getElementById('writeReviewBtn').onclick = function() {
            document.getElementById('reviewModal').style.display = 'block';
        };
    </script>
</body>
</html>
