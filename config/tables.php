<?php
require_once 'database.php';

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

// Create products table
$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
    stock INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

// Create orders table
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// Create order_items table
$sql_order_items = "CREATE TABLE IF NOT EXISTS order_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
)";

// Execute the queries
if (!mysqli_query($conn, $sql_users)) {
    die("Error creating users table: " . mysqli_error($conn));
}

if (!mysqli_query($conn, $sql_products)) {
    die("Error creating products table: " . mysqli_error($conn));
}

if (!mysqli_query($conn, $sql_orders)) {
    die("Error creating orders table: " . mysqli_error($conn));
}

if (!mysqli_query($conn, $sql_order_items)) {
    die("Error creating order_items table: " . mysqli_error($conn));
}

echo "Database tables created successfully";
?> 