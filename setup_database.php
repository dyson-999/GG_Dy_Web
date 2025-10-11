<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Database Setup Progress:</h2>";

// Read and execute SQL file
$sql = file_get_contents('database.sql');
if ($conn->multi_query($sql)) {
    echo "<p style='color: green;'>✓ Database and tables created successfully</p>";
    
    // Check if tables were created
    $tables = ['users', 'products', 'orders', 'order_items', 'cart', 'faqs'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Table '$table' was not created</p>";
        }
    }
    
    // Test webmaster account
    $result = $conn->query("SELECT * FROM users WHERE username = 'webmaster'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Webmaster account created successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Webmaster account was not created</p>";
    }
    
    // Test sample products
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "<p style='color: green;'>✓ Sample products added successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Sample products were not added</p>";
    }
    
    // Test sample FAQs
    $result = $conn->query("SELECT COUNT(*) as count FROM faqs");
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "<p style='color: green;'>✓ Sample FAQs added successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Sample FAQs were not added</p>";
    }
} else {
    echo "<p style='color: red;'>Error creating database: " . $conn->error . "</p>";
}

$conn->close();

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Check if all tables were created successfully</li>";
echo "<li>Verify the webmaster account (username: webmaster, password: password)</li>";
echo "<li>Test the sample products and FAQs</li>";
echo "<li>If any errors occurred, check the error messages above</li>";
echo "</ol>";

echo "<p><a href='test_connection.php'>Click here to test database connection</a></p>";
?> 