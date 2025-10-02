<?php
session_start();
include '../config/config.php';
include '../components/navbar.php';
include '../components/footer.php';

// Get the product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}
$product_id = intval($_GET['id']);

// Fetch product from DB using prepared statement
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Product not found.");
}
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Website title -->
    <title><?php echo htmlspecialchars($product['name']); ?> - Gayakami</title>

    <!-- Favicons & Web Manifest -->
    <link rel="icon" type="image/x-icon" href="../../assets/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon.png">
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

    <div class="product-detail">
        <div class="product-image">
            <img src="../../assets/img/gayakami/<?php echo htmlspecialchars($product['image']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price">Rp <?php echo number_format($product['price'], 2); ?></p>
            <p class="stock">Stock Available: <?php echo $product['stock']; ?> units</p>
            <div class="description">
                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <form method="post" action="../carts/add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1"
                        min="1" max="<?php echo $product['stock']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            <?php else: ?>
                <p class="out-of-stock">Out of Stock</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="navigation-links">
        <a href="../../index.php">← Back to Shop</a>
        <a href="../carts/cart.php">View Cart →</a>
    </div>
    <?php renderFooter(); ?>
</body>

</html>