<?php
require_once '../config/database.php';
require_once '../config/session.php';

// Check if user is logged in and is webmaster
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'webmaster') {
    header('Location: ../login.php');
    exit();
}

$message = '';

// Handle FAQ deletion
if (isset($_POST['delete_faq'])) {
    $faq_id = mysqli_real_escape_string($conn, $_POST['faq_id']);
    mysqli_query($conn, "DELETE FROM faqs WHERE id = '$faq_id'");
    $message = '<div class="alert alert-success">FAQ deleted successfully!</div>';
}

// Handle FAQ update
if (isset($_POST['update_faq'])) {
    $faq_id = mysqli_real_escape_string($conn, $_POST['faq_id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    $sql = "UPDATE faqs SET question = ?, answer = ?, category = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $question, $answer, $category, $faq_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = '<div class="alert alert-success">FAQ updated successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error updating FAQ: ' . mysqli_error($conn) . '</div>';
        }
        mysqli_stmt_close($stmt);
    }
}

// Get all FAQs
$faqs = [];
$result = mysqli_query($conn, "SELECT * FROM faqs ORDER BY category, id");
while ($row = mysqli_fetch_assoc($result)) {
    $faqs[] = $row;
}

// Get unique categories
$categories = [];
$result = mysqli_query($conn, "SELECT DISTINCT category FROM faqs ORDER BY category");
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Management - GGDy Admin</title>
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
        .faqs-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .faqs-table th,
        .faqs-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .faqs-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .faqs-table tr:hover {
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
        .add-faq {
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
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>FAQ Management</h1>
        
        <div class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products.php">Product Management</a>
            <a href="orders.php">Order Management</a>
            <a href="faqs.php">FAQ Management</a>
            <a href="../auth/logout.php">Logout</a>
        </div>

        <?php echo $message; ?>

        <div class="add-faq">
            <a href="add_faq.php" class="btn btn-primary">Add New FAQ</a>
        </div>

        <table class="faqs-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                <tr>
                    <td><?php echo $faq['id']; ?></td>
                    <td>
                        <span class="category-badge">
                            <?php echo htmlspecialchars($faq['category']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($faq['question']); ?></td>
                    <td><?php echo htmlspecialchars($faq['answer']); ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="toggleEditForm(<?php echo $faq['id']; ?>)">
                            Edit
                        </button>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="faq_id" value="<?php echo $faq['id']; ?>">
                            <button type="submit" name="delete_faq" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this FAQ?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div id="edit-form-<?php echo $faq['id']; ?>" class="edit-form">
                            <form method="POST">
                                <input type="hidden" name="faq_id" value="<?php echo $faq['id']; ?>">
                                <div class="form-group">
                                    <label for="category-<?php echo $faq['id']; ?>">Category</label>
                                    <input type="text" id="category-<?php echo $faq['id']; ?>" 
                                           name="category" class="form-control" 
                                           value="<?php echo htmlspecialchars($faq['category']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="question-<?php echo $faq['id']; ?>">Question</label>
                                    <input type="text" id="question-<?php echo $faq['id']; ?>" 
                                           name="question" class="form-control" 
                                           value="<?php echo htmlspecialchars($faq['question']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="answer-<?php echo $faq['id']; ?>">Answer</label>
                                    <textarea id="answer-<?php echo $faq['id']; ?>" 
                                              name="answer" class="form-control" required><?php 
                                        echo htmlspecialchars($faq['answer']); 
                                    ?></textarea>
                                </div>
                                <button type="submit" name="update_faq" class="btn btn-primary">Update FAQ</button>
                                <button type="button" class="btn btn-danger" 
                                        onclick="toggleEditForm(<?php echo $faq['id']; ?>)">Cancel</button>
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