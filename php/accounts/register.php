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

    <!-- Register - Gayakami -->
    <title>Register - Gayakami</title>

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

        <div class="register-box">
            <h1>Register</h1>
            <div class="account-info">
                <form method="post">
                    <div class="info-group">
                        <label><i class="fas fa-user"></i> Username : </label>
                        <p><input type="text" name="username" placeholder="Username" required></p>
                    </div>
                    <div class="info-group">
                        <label><i class="fas fa-envelope"></i> Email :</label>
                        <p><input type="email" name="email" placeholder="Email" required></p>
                    </div>
                    <div class="info-group">
                        <label><i class="fas fa-key"></i> Password : </label>
                        <p><input type="password" name="password" placeholder="Password" required></p>
                    </div>
            </div>
            <div class="register-actions">
                <button type="submit" class="btn edit-btn">Register</button>
                </form>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure hash

            // Replace direct query with:
            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            $stmt = secure_query($conn, $sql, "sss", [$username, $password, $email]);

            if ($stmt) {
                echo "Registered successfully!";
                header("Location: login.php");
            } else {
                echo "Error: " . $conn->error;
            }
        }
        $conn->close();
        ?>
    </div>
</body>

</html>