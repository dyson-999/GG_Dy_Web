<?php
require_once 'config/database.php';

// Webmaster credentials
$username = 'webmaster';
$email = 'webmaster@ggdy.com';
$password = 'password123'; // This will be the new password
$role = 'webmaster';

// Generate password hash
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// First, check if webmaster exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing webmaster
    $stmt = $conn->prepare("UPDATE users SET password = ?, email = ?, role = ? WHERE username = ?");
    $stmt->bind_param("ssss", $password_hash, $email, $role, $username);
} else {
    // Create new webmaster
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password_hash, $role);
}

if ($stmt->execute()) {
    echo "<h2>Webmaster Account Setup</h2>";
    echo "<p style='color: green;'>✓ Webmaster account setup successful!</p>";
    echo "<p>Username: webmaster</p>";
    echo "<p>Password: password123</p>";
    echo "<p>Please use these credentials to log in.</p>";
} else {
    echo "<p style='color: red;'>Error setting up webmaster account: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?> 