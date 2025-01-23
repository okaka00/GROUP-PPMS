<?php
// Include database configuration
include("../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $categoryID = intval($_GET['id']);

    // Retrieve the existing category data using a prepared statement
    $sql = "SELECT * FROM toolCategory WHERE categoryID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryName'];
        $categoryDesc = $row['categoryDesc'];
    } else {
        echo "Category not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Category Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    $categoryDesc = $_POST['categoryDesc'];

    // Update the category using a prepared statement
    $sql_update = "UPDATE toolCategory SET categoryName = ?, categoryDesc = ? WHERE categoryID = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssi", $categoryName, $categoryDesc, $categoryID);

    if (mysqli_stmt_execute($stmt_update)) {
        echo "Category updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_update);
    mysqli_close($conn);

    // Redirect to tools list or display a success message
    header("Location: toolsList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Edit Category</title>
    <style>
        .main {
            padding: 30px;
        }

        .rowform {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .rowform label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .rowform input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button {
            background-color: black;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: gray;
        }
    </style>
</head>

<body>
    <!-- Top navigation bar with logo -->
    <div class="topNav">
        <img src="../../img/icon.png" alt="Logo">
    </div>

    <!-- Include side navigation -->
    <?php include '../../includes/sideNav.php'; ?>

    <!-- Main content area -->
    <div class="main">
        <h2 style="text-align: center;">Edit Category</h2>
        <div class="rowform">
            <!-- Form for editing category -->
            <form action="" method="POST">
                <input type="hidden" name="categoryID" value="<?= htmlspecialchars($categoryID) ?>">

                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($categoryName) ?>"
                    required>

                <label for="categoryDesc">Category Description:</label>
                <input type="text" id="categoryDesc" name="categoryDesc" value="<?= htmlspecialchars($categoryDesc) ?>"
                    required>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>

</html>