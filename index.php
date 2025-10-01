<?php
include 'php/config/config.php';
include 'php/components/navbar.php';
include 'php/components/footer.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Website title -->
    <title>GayaKami</title>

    <!-- Favicons & Web Manifest -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <!-- Styles & Fonts -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <?php renderNavbar(""); ?>
    <div class="main-content">
        <?php if(isset($_SESSION['user_id'])): 
            $sql = "SELECT username FROM users WHERE id = ?";
            $stmt = secure_query($conn, $sql, "i", [$_SESSION['user_id']]);
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        ?>
            <div class="welcome-message">
                <h3>Welcome back, <?php echo htmlspecialchars($user['username']); ?>!</h3>
            </div>
        <?php endif; ?>

        <!-- Hero section -->
        <div class="hero-parallax">
            <div class="hero-text">
                <h2>Welcome to GayaKami</h2>
                <p>Explore Our Latest Collections</p>
            </div>
        </div>

        <!-- Products Section -->
        <h2>Browse our Collections</h2>
        <div class="products">
            <?php
            $sql = "SELECT * FROM products";
            $stmt = secure_query($conn, $sql, null, null);
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<div class='product-image'>";
                    echo "<a href='php/products/product.php?id=" . $row['id'] . "'>";
                    echo "<img src='assets/img/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                    echo "</a>";
                    echo "</div>";
                    echo "<h2>" . $row['name'] . "</h2>";
                    echo "<p class='description'>" . $row['description'] . "</p>";
                    echo "<p class='price'>Rp" . $row['price'] . " (Stock: " . $row['stock'] . ")</p>";
                    echo "<form method='post' action='php/carts/add_to_cart.php'>";
                    echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                    echo "<input type='number' name='quantity' value='1' min='1' max='" . $row['stock'] . "'>";
                    echo "<button type='submit'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "No products available.";
            }
            $conn->close();
            ?>
        </div>

    </div>
    <?php renderFooter(); ?>
</body>
</html>