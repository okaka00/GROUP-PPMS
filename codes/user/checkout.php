<?php
session_start();
include("config/config.php");

// Initialize cart session if not set
if (!isset($_SESSION['cart_item'])) {
    $_SESSION['cart_item'] = [];
}

// Handle add action
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Fetch item details from the database
    if (isset($_GET['type']) && $_GET['type'] == 'campsite') {
        $sql = "SELECT * FROM campsite WHERE campsiteID = $id";
    } else {
        $sql = "SELECT * FROM tool WHERE toolID = $id";
    }

    $result = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($result);

    if ($item) {
        // Check if item already exists in cart
        if (isset($_SESSION['cart_item'][$item['campsiteID'] ?? $item['toolID']])) {
            $_SESSION['cart_item'][$item['campsiteID'] ?? $item['toolID']]["quantity"] += $quantity; // Update quantity
        } else {
            $_SESSION['cart_item'][$item['campsiteID'] ?? $item['toolID']] = [
                "name" => $item['campsiteName'] ?? $item['toolName'],
                "id" => $item['campsiteID'] ?? $item['toolID'],
                "quantity" => $quantity,
                "price" => $item['campsitePrice'] ?? $item['pricePerDay']
            ];
        }
    }

    header("Location: campsite.php"); // Redirect back to campsite page
    exit();
}

$total_quantity = 0;
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/newstyle.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 25px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding-bottom: 40px;
    }

    h1 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 15px;
        text-align: center;
    }

    th {
        background-color: #f0f0f0;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #fff;
    }

    .summary {
        text-align: right;
        margin-top: 20px;
    }

    .summary span {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
    margin-bottom: 20px;
}


    .checkout-btn, .cancel-btn {
        padding: 15px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        margin-bottom: 50px;
    }

    .checkout-btn {
        background-color: #4caf50;
        color: #fff;
        margin-left: 10px;
    }

    .checkout-btn:hover {
        background-color: #45a049;
    }

    .cancel-btn {
        background-color: #f44336;
        color: #fff;
    }

    .cancel-btn:hover {
        background-color: #d32f2f;
    }

    @media (max-width: 768px) {
        table th, table td {
            font-size: 0.9rem;
            padding: 10px;
        }

        .actions {
            flex-direction: column;
        }
    }
</style>
</head>

<body>
<!-- User Nav section-->
<?php include("includes/userNav.php"); ?>
<!-- Navigation Menu -->
<?php include("includes/topNav.php"); ?>

<!-- Place banner under menu for bigger space -->
<img class="image" src="img/banner.png">

<!-- Main container for sticky footer -->
<div class="container">
    <h1>Confirm your order</h1>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Unit Price (RM)</th>
                <th>Total Price (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['cart_item'])): ?>
                <?php foreach ($_SESSION['cart_item'] as $item): ?>
                    <?php
                    $item_total = $item["quantity"] * $item["price"];
                    $total_quantity += $item["quantity"];
                    $total_price += $item_total;
                    ?>
                    <tr>
                        <td><?php echo $item["name"]; ?></td>
                        <td><?php echo $item["id"]; ?></td>
                        <td><?php echo $item["quantity"]; ?></td>
                        <td><?php echo number_format($item["price"], 2); ?></td>
                        <td><?php echo number_format($item_total, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Your cart is empty!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
            <p>Total Items: <span><?php echo $total_quantity; ?></span></p>
            <p>Total Price: <span>RM <?php echo number_format($total_price, 2); ?></span></p>
        <a href="cart_action.php" class="cancel-btn">Cancel</a>
        <a href="my_order.php" class="checkout-btn">Confirm Order</a>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>Copyright &copy; 2025 Mamahill Camp. All rights reserved.</p>
</footer>
</body>
</html>
