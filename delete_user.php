<?php 
include 'db_connection.php';
session_start(); // Start the session to store messages

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User has been deleted successfully!";
        $_SESSION['message_type'] = "success"; // You can use this to style the message
    } else {
        $_SESSION['message'] = "Error deleting user: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to manage_users.php
    header("Location: manage_users.php");
    exit(); // Ensure script stops execution after redirection
}
?>