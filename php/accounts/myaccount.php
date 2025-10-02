<?php
session_start();
include '../config/config.php';
include '../components/navbar.php';
include '../components/footer.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = secure_query($conn, $sql, "i", [$_SESSION['user_id']]);
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Website title -->
    <title>My Account - Gayakami</title>

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

    <div class="main-content">
        <div class="account-container">
            <h1>My Account</h1>

            <div class="account-info">
                <div class="info-group">
                    <label><i class="fas fa-user"></i> Username</label>
                    <p><?php echo htmlspecialchars($user['username']); ?></p>
                </div>

                <div class="info-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>

                <div class="info-group">
                    <label><i class="fas fa-key"></i> Password</label>
                    <p>••••••••</p>
                </div>
            </div>

            <div class="account-actions">
                <a href="edit_profile.php" class="btn edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
                <a href="change_password.php" class="btn password-btn">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </div>
        </div>
    </div>
    <?php renderFooter(); ?>
</body>

</html>