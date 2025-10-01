<?php 
include '../config/config.php';
include '../components/navbar.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - GayaKami</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php renderNavbar("../../"); ?>
    <div class="main-content">
        <h1>Login</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register here</a>
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
</body>

</html>