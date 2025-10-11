<?php
require_once '../config/database.php';
require_once '../config/session.php';

// Check if user is logged in and is webmaster
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'webmaster') {
    header('Location: ../login.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    $sql = "INSERT INTO faqs (question, answer, category) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $question, $answer, $category);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = '<div class="alert alert-success">FAQ added successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error adding FAQ: ' . mysqli_error($conn) . '</div>';
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Get existing categories
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
    <title>Add FAQ - GGDy Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container {
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
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
            height: 150px;
            resize: vertical;
        }
        .btn {
            padding: 10px 20px;
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
        .category-suggestions {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
        .category-suggestions span {
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
            color: #007bff;
        }
        .category-suggestions span:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Add New FAQ</h1>
        
        <div class="admin-nav">
            <a href="index.php">Dashboard</a>
            <a href="users.php">User Management</a>
            <a href="products.php">Product Management</a>
            <a href="orders.php">Order Management</a>
            <a href="faqs.php">FAQ Management</a>
            <a href="../auth/logout.php">Logout</a>
        </div>

        <?php echo $message; ?>

        <form method="POST">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" class="form-control" required>
                <?php if (!empty($categories)): ?>
                <div class="category-suggestions">
                    Existing categories: 
                    <?php foreach ($categories as $cat): ?>
                    <span onclick="document.getElementById('category').value = '<?php echo htmlspecialchars($cat); ?>'">
                        <?php echo htmlspecialchars($cat); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" id="question" name="question" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea id="answer" name="answer" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add FAQ</button>
        </form>
    </div>
</body>
</html> 