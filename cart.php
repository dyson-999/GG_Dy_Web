<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'config/cart.php';

// Get cart items
$cart_items = getCartItems();
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - GGDy</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th,
        .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .cart-table th {
            background-color: #f8f9fa;
        }
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
        }
        .cart-total {
            text-align: right;
            font-size: 1.2em;
            margin: 20px 0;
        }
        .checkout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .checkout-btn:hover {
            background-color: #0056b3;
        }
        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="cart-container">
        <h1>Shopping Cart</h1>

        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Browse our products and add items to your cart.</p>
                <a href="shop.php" class="checkout-btn">Continue Shopping</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="POST" action="update_cart.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                       min="1" max="<?php echo $item['stock']; ?>" 
                                       class="quantity-input" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form method="POST" action="remove_from_cart.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total">
                <strong>Total: $<?php echo number_format($total, 2); ?></strong>
            </div>

            <div style="text-align: right;">
                <a href="shop.php" class="btn">Continue Shopping</a>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 