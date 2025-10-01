<?php
session_start();
include '../config/config.php';
include '../components/navbar.php';
include '../components/footer.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../accounts/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Website title -->
    <title>Carts - GayaKami</title>

    <!-- Favicons & Web Manifest -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <!-- Styles & Fonts -->
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <?php renderNavbar("../../"); ?>
    <div class="main-content">
        <div class="cart-container">
            <h1>Shopping Cart</h1>

            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <div class="cart-header">
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Subtotal</div>
                </div>
                <ul class="cart-items">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <li class="cart-item">
                            <div><?php echo htmlspecialchars($item['name']); ?></div>
                            <div>$<?php echo number_format($item['price'], 2); ?></div>
                            <div><?php echo $item['quantity']; ?></div>
                            <div>$<?php echo number_format($subtotal, 2); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="cart-total">
                    <span>Total: $<?php echo number_format($total, 2); ?></span>
                </div>

                <div class="cart-buttons">
                    <a href="../payments/checkout.php" class="checkout-btn">
                        <i class="fas fa-shopping-cart"></i> Proceed to Checkout
                    </a>
                    <a href="#" onclick="confirmClearCart('clear_cart.php'); return false;" class="clear-cart-btn">
                        <i class="fas fa-trash"></i> Clear Cart
                    </a>
                    <a href="../../index.php" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart fa-3x"></i>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <div class="cart-buttons">
                        <a href="../../index.php" class="continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php renderFooter(); ?>
</body>

<script>
    function confirmClearCart(clearCartUrl) {
        if (confirm('Are you sure you want to clear your cart? This action cannot be undone.')) {
            window.location.href = clearCartUrl;
        }
    }
</script>

</html>