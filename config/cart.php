<?php
require_once 'database.php';
require_once 'products.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add item to cart
function addToCart($product_id, $quantity = 1) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// Remove item from cart
function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Update cart item quantity
function updateCartQuantity($product_id, $quantity) {
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        removeFromCart($product_id);
    }
}

// Get cart items with product details
function getCartItems() {
    $items = array();
    $total = 0;
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product = getProductById($product_id);
        if ($product) {
            $item = array(
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'subtotal' => $product['price'] * $quantity,
                'image_url' => $product['image_url']
            );
            $items[] = $item;
            $total += $item['subtotal'];
        }
    }
    
    return array(
        'items' => $items,
        'total' => $total
    );
}

// Clear cart
function clearCart() {
    $_SESSION['cart'] = array();
}

// Get cart total
function getCartTotal() {
    $cart = getCartItems();
    return $cart['total'];
}

// Get cart item count
function getCartItemCount() {
    return array_sum($_SESSION['cart']);
}

// Create order from cart
function createOrder($user_id) {
    global $conn;
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Create order
        $cart = getCartItems();
        $sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "id", $user_id, $cart['total']);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error creating order");
            }
            
            $order_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
            
            // Add order items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                foreach ($cart['items'] as $item) {
                    mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                    
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Error adding order items");
                    }
                }
                mysqli_stmt_close($stmt);
            }
            
            // Update product stock
            foreach ($cart['items'] as $item) {
                $product = getProductById($item['id']);
                $new_stock = $product['stock'] - $item['quantity'];
                
                if ($new_stock < 0) {
                    throw new Exception("Insufficient stock for product: " . $product['name']);
                }
                
                $sql = "UPDATE products SET stock = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ii", $new_stock, $item['id']);
                    
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Error updating product stock");
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            
            // Commit transaction
            mysqli_commit($conn);
            
            // Clear cart
            clearCart();
            
            return $order_id;
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        throw $e;
    }
    
    return false;
}
?> 