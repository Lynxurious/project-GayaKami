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

// Fetch current user data
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = secure_query($conn, $sql, "i", [$_SESSION['user_id']]);
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    // Validate input
    if (empty($username) || empty($email)) {
        $message = "All fields are required";
    } else {
        // Update user info
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = secure_query($conn, $sql, "ssi", [$username, $email, $_SESSION['user_id']]);
        
        if ($stmt) {
            $message = "Profile updated successfully!";
            // Update displayed data
            $user['username'] = $username;
            $user['email'] = $email;
        } else {
            $message = "Error updating profile";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - GayaKami</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php renderNavbar("../../"); ?>
    
    <div class="main-content">
        <div class="account-container">
            <h1>Edit Profile</h1>
            
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="edit-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn save-btn">
                        <i class="fas fa-save"></i> Save Changes
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