<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $error = "";

    // Validate input
    if (empty($username) || empty($password) || empty($email)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if username exists
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $error = "This username is already taken.";
                }
            }
            mysqli_stmt_close($stmt);
        }

        // Check if email exists
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $error = "This email is already registered.";
                }
            }
            mysqli_stmt_close($stmt);
        }

        // If no errors, proceed with registration
        if (empty($error)) {
            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);
                
                if (mysqli_stmt_execute($stmt)) {
                    header("location: login.php");
                    exit();
                } else {
                    $error = "Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?> 