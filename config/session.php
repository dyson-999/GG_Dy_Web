<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
function checkLogin() {
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}

// Get current user's information
function getCurrentUser() {
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        return [
            'id' => $_SESSION["id"],
            'username' => $_SESSION["username"]
        ];
    }
    return null;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
}

// Logout user
function logout() {
    // Unset all of the session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header("location: login.php");
    exit;
}
?> 