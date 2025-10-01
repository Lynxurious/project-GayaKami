<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function for secure queries
function secure_query($conn, $sql, $types, $params) {
    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

// Midtrans configuration

// Go to https://dashboard.sandbox.midtrans.com/register (sandbox for testing).
// Sign up with your email/phone. Verify and log in.
// In dashboard: Go to Settings > Access Keys—copy Server Key (secret, for backend) and Client Key (public, for frontend).
// Enable methods: Settings > Payment Methods > Turn on DANA, ShopeePay, QRIS.
// Set Notification URL: Later, it'll be something like http://your-site.com/notification_handler.php (use ngrok for local testing—see below).


require_once 'vendor/autoload.php';

\Midtrans\Config::$serverKey = '';          // From dashboard (keep secret!)
\Midtrans\Config::$clientKey = '';          // From dashboard
\Midtrans\Config::$isProduction = false;    // False for testing (sandbox), true for live site
\Midtrans\Config::$isSanitized = true;      // Cleans inputs for security
\Midtrans\Config::$is3ds = true;            // Extra security for cards (optional, but good)

?>
