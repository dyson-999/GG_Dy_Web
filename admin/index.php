<?php
require_once '../config/database.php';
require_once '../config/session.php';

// Check if user is logged in and is webmaster
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'webmaster') {
    header('Location: ../login.php');
    exit();
}

// Get statistics
$stats = [
    'total_users' => 0,
    'total_products' => 0,
    'total_orders' => 0,
    'total_faqs' => 0
];

// Get total users
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
if ($row = mysqli_fetch_assoc($result)) {
    $stats['total_users'] = $row['count'];
}

// Get total products
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
if ($row = mysqli_fetch_assoc($result)) {
    $stats['total_products'] = $row['count'];
}

// Get total orders
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders");
if ($row = mysqli_fetch_assoc($result)) {
    $stats['total_orders'] = $row['count'];
}

// Get total FAQs
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM faqs");
if ($row = mysqli_fetch_assoc($result)) {
    $stats['total_faqs'] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webmaster Dashboard - GGDy</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-nav {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .admin-nav a {
            margin-right: 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .admin-nav a:hover {
            color: #007bff;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #007bff;
        }
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .management-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .management-card h2 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 1.5em;
        }
        .management-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .management-card li {
            margin-bottom: 10px;
        }
        .management-card a {
            text-decoration: none;
            color: #007bff;
            display: block;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .management-card a:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Webmaster Dashboard</h1>
        
        <div class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products.php">Product Management</a>
            <a href="orders.php">Order Management</a>
            <a href="faqs.php">FAQ Management</a>
            <a href="../auth/logout.php">Logout</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo $stats['total_users']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?php echo $stats['total_products']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?php echo $stats['total_orders']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total FAQs</h3>
                <p><?php echo $stats['total_faqs']; ?></p>
            </div>
        </div>

        <div class="management-grid">
            <div class="management-card">
                <h2>User Management</h2>
                <ul>
                    <li><a href="users.php?type=admin">Manage Administrators</a></li>
                    <li><a href="users.php?type=user">Manage Users</a></li>
                    <li><a href="users.php?type=customer">Manage Customers</a></li>
                    <li><a href="users.php?action=add">Add New User</a></li>
                </ul>
            </div>

            <div class="management-card">
                <h2>Product Management</h2>
                <ul>
                    <li><a href="products.php">View All Products</a></li>
                    <li><a href="add_product.php">Add New Product</a></li>
                    <li><a href="categories.php">Manage Categories</a></li>
                    <li><a href="inventory.php">Inventory Management</a></li>
                </ul>
            </div>

            <div class="management-card">
                <h2>Order Management</h2>
                <ul>
                    <li><a href="orders.php">View All Orders</a></li>
                    <li><a href="orders.php?status=pending">Pending Orders</a></li>
                    <li><a href="orders.php?status=completed">Completed Orders</a></li>
                    <li><a href="orders.php?status=cancelled">Cancelled Orders</a></li>
                </ul>
            </div>

            <div class="management-card">
                <h2>FAQ Management</h2>
                <ul>
                    <li><a href="faqs.php">View All FAQs</a></li>
                    <li><a href="add_faq.php">Add New FAQ</a></li>
                    <li><a href="faq_categories.php">Manage FAQ Categories</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html> 