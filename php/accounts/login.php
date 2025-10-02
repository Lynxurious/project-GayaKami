<?php
session_start();
include '../config/config.php';
include '../components/navbar.php';
include '../components/footer.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Login - Gayakami -->
    <title>Login - Gayakami</title>

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
        <div class="login-box">
            <h1>Login</h1>
            <div class="account-info">
                <form method="post">
                    <div class="info-group">
                        <label><i class="fas fa-user"></i> Username : </label>
                        <p><input type="text" name="username" placeholder="Username" required></p>
                    </div>
                    <div class="info-group">
                        <label><i class="fas fa-key"></i> Password : </label>
                        <p><input type="password" name="password" placeholder="Password" required></p>
                    </div>
            </div>
            <div class="login-actions">
                <button type="submit" class="btn edit-btn">Login</button>
                </form>
                <p><a href="register.php">Don't have an account? Register here</a></p>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                // Replace direct query with:
                $sql = "SELECT * FROM users WHERE username = ?";
                $stmt = secure_query($conn, $sql, "s", [$username]);
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($_POST['password'], $user['password'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header("Location: ../../index.php");
                        exit();
                    } else {
                        echo "<p>Invalid username or password.</p>";
                    }
                } else {
                    echo "<p>Invalid username or password.</p>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php // renderFooter(); 
    ?>
</body>

</html>