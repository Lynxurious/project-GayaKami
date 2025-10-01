<?php
session_start();
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = secure_query($conn, $sql, "i", [$product_id]);
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product['stock'] >= $quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        ];
    }
}

// Check the referer to determine where to redirect back to
$referer = $_SERVER['HTTP_REFERER'];
if (strpos($referer, 'product.php') !== false) {
    header("Location: ../products/product.php?id=" . $product_id);
} else {
    header("Location: ../../index.php");
}
$conn->close();
?>
