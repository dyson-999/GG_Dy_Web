<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'config/cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($product_id > 0 && $quantity > 0) {
        // Check if product exists and has enough stock
        $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if ($quantity <= $row['stock']) {
                // Update cart
                $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("iii", $quantity, $_SESSION['user_id'], $product_id);
                $stmt->execute();
            }
        }
    }
}

// Redirect back to cart
header('Location: cart.php');
exit(); 