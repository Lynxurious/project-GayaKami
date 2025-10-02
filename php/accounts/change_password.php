<?php
session_start();
include '../config/config.php';
include '../components/navbar.php';
include '../components/footer.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = secure_query($conn, $sql, "i", [$_SESSION['user_id']]);
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = secure_query($conn, $sql, "si", [$hashed_password, $_SESSION['user_id']]);

            if ($stmt) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password";
            }
        } else {
            $message = "New passwords do not match";
        }
    } else {
        $message = "Current password is incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Change Password - Gayakami -->
    <title>Change Password - Gayakami</title>

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
            <h1>Change Password</h1>

            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="edit-form">
                <div class="form-group">
                    <label for="current_password"><i class="fas fa-key"></i> Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password"><i class="fas fa-lock"></i> New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn save-btn">
                        <i class="fas fa-save"></i> Change Password
                    </button>
                    <a href="myaccount.php" class="btn cancel-btn">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php renderFooter(); ?>
</body>

</html>