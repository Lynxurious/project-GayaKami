<?php include '../config/config.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
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
</body>

</html>