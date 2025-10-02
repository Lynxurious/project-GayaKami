<?php
function renderNavbar($relativePath = "") {
    ?>
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo $relativePath; ?>index.php" class="nav-brand">Gayakami</a>
            <div class="nav-links">
                <a href="<?php echo $relativePath; ?>index.php">Home</a>
                <a href="<?php echo $relativePath; ?>index.php">Categories</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $relativePath; ?>php/accounts/myaccount.php">My Account</a>
                    <a href="#" onclick="confirmLogout('<?php echo $relativePath; ?>php/accounts/logout_handler.php'); return false;">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $relativePath; ?>php/accounts/login.php">Login</a>
                    <a href="<?php echo $relativePath; ?>php/accounts/register.php">Register</a>
                <?php endif; ?>
                <a href="<?php echo $relativePath; ?>php/carts/cart.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <?php
                    if(isset($_SESSION['cart'])) {
                        $cart_count = count($_SESSION['cart']);
                        echo "<span>($cart_count)</span>";
                    }
                    ?>
                </a>
            </div>
        </div>
    </nav>

    <script>
    function confirmLogout(logoutUrl) {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = logoutUrl;
        }
    }
    </script>
    <?php
}
?>