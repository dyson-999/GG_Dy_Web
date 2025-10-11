<?php
require_once 'config/database.php';

echo "<h2>Database Connection Test</h2>";

// Test connection
if ($conn->connect_error) {
    die("<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color: green;'>✓ Database connection successful</p>";

// Test database selection
if ($conn->select_db('ggdy_db')) {
    echo "<p style='color: green;'>✓ Database 'ggdy_db' selected successfully</p>";
} else {
    echo "<p style='color: red;'>✗ Failed to select database 'ggdy_db'</p>";
}

// Get table information
$tables = ['users', 'products', 'orders', 'order_items', 'cart', 'faqs'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        // Get row count
        $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
        echo "<p style='color: green;'>✓ Table '$table' exists with $count rows</p>";
    } else {
        echo "<p style='color: red;'>✗ Table '$table' does not exist</p>";
    }
}

// Test webmaster login
$username = 'webmaster';
$password = 'password';
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo "<p style='color: green;'>✓ Webmaster login test successful</p>";
    } else {
        echo "<p style='color: red;'>✗ Webmaster password verification failed</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Webmaster account not found</p>";
}

$conn->close();

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>If all tests passed, your database is properly configured</li>";
echo "<li>If any tests failed, check the error messages above</li>";
echo "<li>Try logging in to the admin panel with the webmaster account</li>";
echo "</ol>";

echo "<p><a href='setup_database.php'>Click here to run database setup again</a></p>";
?> 