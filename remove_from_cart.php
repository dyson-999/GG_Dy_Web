<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'config/cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

    if ($product_id > 0) {
        // Remove item from cart
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
        $stmt->execute();
    }
}

// Redirect back to cart
header('Location: cart.php');
exit(); 