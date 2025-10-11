<?php
session_start();

// Check if the user is already logged in, if yes then redirect to index page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

require_once "config/database.php";
require_once "config/session.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;
                            
                            // Redirect based on role
                            if($role === 'webmaster'){
                                header("location: admin/index.php");
                            } else {
                                header("location: index.php");
                            }
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Dy Gaming Store</title>
<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/544d79f6c0.js" crossorigin="anonymous"></script>
<style>
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    .btn {
        width: 100%;
        padding: 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn:hover {
        background: #0056b3;
    }
    .error {
        color: #dc3545;
        margin-bottom: 15px;
    }
    .register-link {
        text-align: center;
        margin-top: 20px;
    }
    .register-link a {
        color: #007bff;
        text-decoration: none;
    }
    .register-link a:hover {
        text-decoration: underline;
    }
</style>
</head>

<body class="login-page">
    <header>
        <div class="logo">Dy Gaming Store</div>
        <nav>
            <ul class="nav-links">
                <li><a href="shop.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="privacy-policy.php">Privacy Policy</a></li>
            </ul>
        </nav>
        <div class="cart-container">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-count">0</span>
            <div class="cart-dropdown">
                <div class="cart-items">
                    <!-- Cart items will be dynamically added here -->
                </div>
                <div class="cart-total">
                    <span>Total: $<span id="cart-total-amount">0.00</span></span>
                </div>
                <button class="checkout-btn">Checkout</button>
            </div>
        </div>
        <a href="index.php" class="home-btn"><i class="fa-solid fa-house"></i> Home</a>
    </header>

    <main class="auth-container">
        <section class="login-section">
            <div class="auth-header">
                <i class="fa-solid fa-user-circle"></i>
                <h2>Login to Your Account</h2>
            </div>
            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>
            <div class="login-container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Username" required>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" required>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>

                    <div class="remember-forgot">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>

                <div class="register-link">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Dy Gaming Store. All Rights Reserved</p>
        <div class="social-links">
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-whatsapp"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-discord"></i>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html> 