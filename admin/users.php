<?php
require_once '../config/database.php';
require_once '../config/session.php';

// Check if user is logged in and is webmaster
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'webmaster') {
    header('Location: ../login.php');
    exit();
}

$message = '';
$user_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
    $message = '<div class="alert alert-success">User deleted successfully!</div>';
}

// Handle user role update
if (isset($_POST['update_role'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $new_role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE users SET role = '$new_role' WHERE id = '$user_id'");
    $message = '<div class="alert alert-success">User role updated successfully!</div>';
}

// Get users based on type
$sql = "SELECT * FROM users";
if ($user_type !== 'all') {
    $sql .= " WHERE role = '" . mysqli_real_escape_string($conn, $user_type) . "'";
}
$sql .= " ORDER BY created_at DESC";

$users = [];
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - GGDy Admin</title>
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
        .users-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .users-table th,
        .users-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .users-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .users-table tr:hover {
            background: #f8f9fa;
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #007bff;
            color: #fff;
        }
        .btn-danger {
            background: #dc3545;
            color: #fff;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .filter-buttons {
            margin-bottom: 20px;
        }
        .filter-buttons a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
            padding: 8px 16px;
            border-radius: 4px;
            background: #f8f9fa;
        }
        .filter-buttons a.active {
            background: #007bff;
            color: #fff;
        }
        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        .role-admin {
            background: #dc3545;
            color: #fff;
        }
        .role-user {
            background: #28a745;
            color: #fff;
        }
        .role-customer {
            background: #17a2b8;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>User Management</h1>
        
        <div class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products.php">Product Management</a>
            <a href="orders.php">Order Management</a>
            <a href="faqs.php">FAQ Management</a>
            <a href="../auth/logout.php">Logout</a>
        </div>

        <?php echo $message; ?>

        <div class="filter-buttons">
            <a href="users.php" class="<?php echo $user_type === 'all' ? 'active' : ''; ?>">All Users</a>
            <a href="users.php?type=admin" class="<?php echo $user_type === 'admin' ? 'active' : ''; ?>">Administrators</a>
            <a href="users.php?type=user" class="<?php echo $user_type === 'user' ? 'active' : ''; ?>">Users</a>
            <a href="users.php?type=customer" class="<?php echo $user_type === 'customer' ? 'active' : ''; ?>">Customers</a>
        </div>

        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span class="role-badge role-<?php echo $user['role']; ?>">
                            <?php echo ucfirst($user['role']); ?>
                        </span>
                    </td>
                    <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="role" onchange="this.form.submit()" style="margin-right: 10px;">
                                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="customer" <?php echo $user['role'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                            </select>
                            <input type="hidden" name="update_role" value="1">
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 