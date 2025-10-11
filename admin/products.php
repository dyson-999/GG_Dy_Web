<?php
require_once '../config/database.php';
require_once '../config/session.php';

// Check if user is logged in and is webmaster
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'webmaster') {
    header('Location: ../login.php');
    exit();
}

$message = '';

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    mysqli_query($conn, "DELETE FROM products WHERE id = '$product_id'");
    $message = '<div class="alert alert-success">Product deleted successfully!</div>';
}

// Handle product update
if (isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    
    $sql = "UPDATE products SET name = ?, description = ?, price = ?, category = ?, stock = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssddsi", $name, $description, $price, $category, $stock, $product_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = '<div class="alert alert-success">Product updated successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error updating product: ' . mysqli_error($conn) . '</div>';
        }
        mysqli_stmt_close($stmt);
    }
}

// Get all products
$products = [];
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY category, name");
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Get unique categories
$categories = [];
$result = mysqli_query($conn, "SELECT DISTINCT category FROM products ORDER BY category");
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - GGDy Admin</title>
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
        .products-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .products-table th,
        .products-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .products-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .products-table tr:hover {
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
        .add-product {
            margin-bottom: 20px;
        }
        .category-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            background: #e9ecef;
            color: #495057;
        }
        .edit-form {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .edit-form.active {
            display: block;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        textarea.form-control {
            height: 100px;
            resize: vertical;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Product Management</h1>
        
        <div class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products.php">Product Management</a>
            <a href="orders.php">Order Management</a>
            <a href="faqs.php">FAQ Management</a>
            <a href="../auth/logout.php">Logout</a>
        </div>

        <?php echo $message; ?>

        <div class="add-product">
            <a href="add_product.php" class="btn btn-primary">Add New Product</a>
        </div>

        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             class="product-image">
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>
                        <span class="category-badge">
                            <?php echo htmlspecialchars($product['category']); ?>
                        </span>
                    </td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="toggleEditForm(<?php echo $product['id']; ?>)">
                            Edit
                        </button>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div id="edit-form-<?php echo $product['id']; ?>" class="edit-form">
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <div class="form-group">
                                    <label for="name-<?php echo $product['id']; ?>">Name</label>
                                    <input type="text" id="name-<?php echo $product['id']; ?>" 
                                           name="name" class="form-control" 
                                           value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description-<?php echo $product['id']; ?>">Description</label>
                                    <textarea id="description-<?php echo $product['id']; ?>" 
                                              name="description" class="form-control" required><?php 
                                        echo htmlspecialchars($product['description']); 
                                    ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="price-<?php echo $product['id']; ?>">Price</label>
                                    <input type="number" id="price-<?php echo $product['id']; ?>" 
                                           name="price" class="form-control" step="0.01" 
                                           value="<?php echo $product['price']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="category-<?php echo $product['id']; ?>">Category</label>
                                    <input type="text" id="category-<?php echo $product['id']; ?>" 
                                           name="category" class="form-control" 
                                           value="<?php echo htmlspecialchars($product['category']); ?>" required>
                                    <?php if (!empty($categories)): ?>
                                    <div class="category-suggestions">
                                        Existing categories: 
                                        <?php foreach ($categories as $cat): ?>
                                        <span onclick="document.getElementById('category-<?php echo $product['id']; ?>').value = '<?php echo htmlspecialchars($cat); ?>'">
                                            <?php echo htmlspecialchars($cat); ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="stock-<?php echo $product['id']; ?>">Stock</label>
                                    <input type="number" id="stock-<?php echo $product['id']; ?>" 
                                           name="stock" class="form-control" 
                                           value="<?php echo $product['stock']; ?>" required>
                                </div>
                                <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                                <button type="button" class="btn btn-danger" 
                                        onclick="toggleEditForm(<?php echo $product['id']; ?>)">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleEditForm(id) {
            const form = document.getElementById('edit-form-' + id);
            form.classList.toggle('active');
        }
    </script>
</body>
</html> 