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
    <title>Checkout - GayaKami</title>

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
        <h2>Checkout Page</h2>
        <p>This is a placeholder for the checkout process.</p>
    </div>
    <?php renderFooter(); ?>
</body>

</html>