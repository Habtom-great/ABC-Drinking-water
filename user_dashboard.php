<?php
session_start();

// Check if the user is logged in and the session variable exists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Safely access the name
$name = $_SESSION['name'] ?? 'user'; // Default to 'Staff' if name is not set

echo "Welcome, $name";
?>
