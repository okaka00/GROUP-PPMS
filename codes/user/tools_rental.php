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
        width: 30%;
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

.tool-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .tool-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 10px;
            width: 150px;
            text-align: center;
            transition: transform 0.2s;
        }

        .tool-item:hover {
            transform: scale(1.05);
        }

        .tool-item img {
            width: 100%;
            border-radius: 8px;
            height: auto;
        }

        .tool-item h3 {
            font-size: 1.2rem;
            color: #34495e;
            margin: 5px 0;
        }

        .tool-item p {
            font-size: 0.9rem;
            color: #555;
        }

        .rent-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 0.9rem;
        }

        .rent-button:hover {
            background-color: #45a049;
        }

        .quantity {
            width: 50px;
            margin: 5px 0;
        }

        /* General Button Styling */
button {
    font-family: 'Roboto', sans-serif;
    font-weight: 500;
    font-size: 1rem;
    padding: 10px 20px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn {
    background: linear-gradient(135deg, #e0e0e0, #cfcfcf); /* Modern gradient */
    border: none; /* Light border for definition */
    color: #333; /* Dark text for contrast */
    font-size: 1rem; /* Adjust font size for better visibility */
    width: 10px; /* Square button dimensions */
    height: 10px;
    border-radius: 10px; /* Slight rounding for a modern look */
    cursor: pointer; /* Pointer cursor for clickability */
    display: inline-flex; /* Centers the text inside */
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease, transform 0.2s ease;
}

.quantity-btn:hover {
    background: linear-gradient(135deg, #d4d4d4, #bdbdbd); /* Slightly darker on hover */
    transform: translateY(-2px); /* Subtle hover effect */
}

.quantity-btn:active {
    background: linear-gradient(135deg, #c2c2c2, #a8a8a8); /* Darker on click */
    transform: translateY(0);
    box-shadow: inset 0px 3px 6px rgba(0, 0, 0, 0.2); /* Click-in effect */
}


/* Add to Cart Button */
.add-to-cart {
    background: linear-gradient(135deg, #4CAF50, #3e8e41);
    color: white;
    font-size: 13px;
    padding: 12px 20px;
    border-radius: 30px;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    transition: background 0.3s, transform 0.2s ease;
    margin-top: 10px;
}

.add-to-cart:hover {
    background: linear-gradient(135deg, #3e8e41, #4CAF50);
    transform: translateY(-2px);
    box-shadow: 0px 5px 15px rgba(72, 239, 72, 0.2);
}

.add-to-cart:active {
    transform: translateY(0);
    box-shadow: none;
}

/* Modern Checkout Button */
.checkout-button {
    background: linear-gradient(135deg, #007BFF, #0056b3);
    color: white;
    font-size: 1rem;
    font-weight: bold;
    padding: 15px 30px;
    border: none;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 255, 0.15);
    display: block; /* Centers the button by making it behave like a block element */
    text-align: center; /* Centers the button text */
    width: fit-content; /* Adjusts width to fit its content */
    margin: 20px auto; /* Ensures the button has space and is centered */
}

.checkout-button:hover {
    background: linear-gradient(135deg, #0056b3, #007BFF);
    box-shadow: 0 6px 15px rgba(0, 0, 255, 0.25);
    transform: translateY(-2px);
}

.checkout-button:active {
    transform: translateY(0);
    box-shadow: none;
}

/* Cart Total Section */
.cart-total {
    margin: 20px 0;
    text-align: center;
    font-family: 'Roboto', sans-serif;
}

.cart-total h3 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.cart-total span {
    color: #007BFF;
    font-size: 1.8rem;
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
    
    <!-- Tools Rental Section -->
<section class="tools-rental">
    <div class="main-introduction">
        <div class="intro-content">
            <h2>Rent Your Tools for Adventure</h2>
            <p>Choose from a variety of high-quality tools for your camping needs. Adjust quantities and add them to your cart for checkout!</p>
        </div>
    </div>
    <div class="highlights">
    <div class="highlight-container">
        <?php
        // Fetch tools from the database
        $sql = "SELECT * FROM tool";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Loop through each tool and display it
            while ($row = mysqli_fetch_assoc($result)) {
                $toolId = htmlspecialchars($row['toolID']);
                $toolName = htmlspecialchars($row['toolName']);
                $toolImg = $row['toolImg'];
                $toolDesc = htmlspecialchars($row['toolDesc']);
                $pricePerDay = htmlspecialchars($row['pricePerDay']);
                ?>
                        <div class="highlight-item">
                            <img src="<?= $toolImg ?>" alt="<?= $toolName ?>" class="highlight-image">
                            <h3><?= $toolName ?></h3>
                            <p><?= $toolDesc ?></p>
                            <p>Price: RM <span id="price-<?= $toolId ?>"><?= $pricePerDay ?></span>/day</p>

                            <p>Total Price: RM <span id="total-price-<?= $toolId ?>"><?= $pricePerDay ?></span></p>

                            <form method="post" action="cart_action.php?action=add&id=<?= $toolId ?>">
                                <input type="hidden" id="product-quantity-<?= $toolId ?>" name="quantity" value="1">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                <?php
            }
        } else {
            echo '<p>No tools available at the moment.</p>';
        }
        ?>
    </div>
</div>

</section>
 <!-- Footer -->
 <footer>
    <p>Copyright &copy; 2024 Mini Café. All rights reserved.</p>
  </footer>
  <script>
    function updateQuantity(action, toolId, unitPrice) {
        const quantitySpan = document.getElementById(quantity-${toolId});
        const totalPriceSpan = document.getElementById(total-price-${toolId});
        const quantityInput = document.getElementById(product-quantity-${toolId});

        let currentQuantity = parseInt(quantitySpan.textContent);

        if (action === 'increase') {
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }

        quantitySpan.textContent = currentQuantity;
        totalPriceSpan.textContent = (currentQuantity * unitPrice).toFixed(2);
        quantityInput.value = currentQuantity;
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