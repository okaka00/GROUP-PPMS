<?php
session_start();
include("config/config.php");

// Initialize cart session if not set
if (!isset($_SESSION['cart_item'])) {
    $_SESSION['cart_item'] = [];
}

$userID = $_SESSION['user_id'];

// Handle add action
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Fetch item details from the database
    // Check if the item is a campsite or a tool
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

// Handle remove action
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id_to_remove = $_GET['id'];

    // Loop through cart items to find the one to remove
    foreach ($_SESSION['cart_item'] as $key => $item) {
        if ($item['id'] == $id_to_remove) {
            unset($_SESSION['cart_item'][$key]);
            break; // Stop after removing the item
        }
    }
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
        /* CSS from previous example */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        .actions a, .checkout-btn {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .actions a {
            color: #f44336;
            border: 1px solid #f44336;
            background: transparent;
        }

        .actions a:hover {
            background-color: #f44336;
            color: #fff;
        }

        .print-btn {
    background-color: #4caf50; /* Same as confirm button */
    color: #fff;
    padding: 15px 25px; /* Match padding */
    border-radius: 5px; /* Match border radius */
    border: none; /* Remove border */
    font-weight: bold; /* Match font weight */
    cursor: pointer; /* Pointer cursor */
    margin-left: 10px; /* Space between buttons */
}

.print-btn:hover {
    background-color: #45a049; /* Same hover effect as confirm button */
}

        .checkout-btn {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 15px 25px;
            text-align: center;
        }

        .checkout-btn:hover {
            background-color: #45a049;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
        }

        .summary span {
            font-size: 1.2rem;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            table th, table td {
                font-size: 0.9rem;
                padding: 10px;
            }

            .checkout-btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
	<!-- User Nav section-->
	<?php
	include("includes/userNav.php");
	?>
	<!-- Navigation Menu -->
	<?php
	include("includes/topNav.php");
	?>

	<!-- Place banner under menu for bigger space -->
	<img class="image" src="img/banner.png">
	
	<!-- Main container for sticky footer -->
	<div class="container">
    <h1>Order Summary</h1>
    
    <?php if (!empty($_SESSION['cart_item'])): ?>
        <div class="receipt">
            <?php foreach ($_SESSION['cart_item'] as $item): ?>
                <?php
                $item_total = $item["quantity"] * $item["price"];
                $total_quantity += $item["quantity"];
                $total_price += $item_total;
                ?>
                <div class="receipt-item">
                    <p><strong>Order Name:</strong> <?php echo $item["name"]; ?></p>
                    <p><strong>User ID:</strong> <?php echo $userID["id"]; ?></p>
                    <p><strong>Total Price:</strong> RM <?php echo number_format($item_total, 2); ?></p>
                    <p><strong>Quantity:</strong> <?php echo $item["quantity"]; ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="summary">
            <p><strong>Total Paid:</strong> <span>RM <?php echo number_format($total_price, 2); ?></span></p>
            <div class="thank-you">
                <p>Thank you! See you in the campsite.</p>
            </div>
            <div class="actions">
                <a href="index.php" class="checkout-btn" onclick="clearCart()">Back Home</a>
                <button onclick="window.print()" class="print-btn">Print Receipt</button> <!-- Print button -->
            </div>
        </div>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>
</div>
<script>
function clearCart() {
    <?php
    // Clear the cart session before redirecting
    $_SESSION['cart_item'] = []; 
    ?>
}
</script>    
    <!-- Footer -->
    <footer>
        <p>Copyright &copy; 2025 Mamahill Camp. All rights reserved.</p>
    </footer>
</body>
</html>
