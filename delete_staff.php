<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Delete staff record
    $delete_query = "DELETE FROM staff WHERE id = $staff_id";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_staff.php?success=Staff deleted successfully!");
    } else {
        header("Location: manage_staff.php?error=Error deleting staff: " . mysqli_error($conn));
    }
} else {
    header("Location: manage_staff.php");
    exit();
}