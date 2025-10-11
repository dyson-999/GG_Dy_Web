<?php
require_once 'database.php';

// Get all products
function getAllProducts() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $products = array();
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    
    return $products;
}

// Get product by ID
function getProductById($id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1) {
                return mysqli_fetch_assoc($result);
            }
        }
        mysqli_stmt_close($stmt);
    }
    return null;
}

// Get products by category
function getProductsByCategory($category) {
    global $conn;
    $sql = "SELECT * FROM products WHERE category = ? ORDER BY created_at DESC";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $category);
        
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $products = array();
            
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
            
            return $products;
        }
        mysqli_stmt_close($stmt);
    }
    return array();
}

// Add new product
function addProduct($name, $description, $price, $category, $image_url, $stock) {
    global $conn;
    $sql = "INSERT INTO products (name, description, price, category, image_url, stock) VALUES (?, ?, ?, ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssdssi", $name, $description, $price, $category, $image_url, $stock);
        
        if(mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

// Update product
function updateProduct($id, $name, $description, $price, $category, $image_url, $stock) {
    global $conn;
    $sql = "UPDATE products SET name = ?, description = ?, price = ?, category = ?, image_url = ?, stock = ? WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssdssii", $name, $description, $price, $category, $image_url, $stock, $id);
        
        if(mysqli_stmt_execute($stmt)) {
            return true;
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

// Delete product
function deleteProduct($id) {
    global $conn;
    $sql = "DELETE FROM products WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if(mysqli_stmt_execute($stmt)) {
            return true;
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

// Search products
function searchProducts($query) {
    global $conn;
    $search = "%" . $query . "%";
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR category LIKE ? ORDER BY created_at DESC";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
        
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $products = array();
            
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
            
            return $products;
        }
        mysqli_stmt_close($stmt);
    }
    return array();
}
?> 