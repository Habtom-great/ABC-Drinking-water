<?php
include 'db_connection.php';
session_start();

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // 1️⃣ Get staff last name BEFORE deleting
    $getStmt = $conn->prepare("SELECT last_name FROM staff WHERE staff_id = ?");
    $getStmt->bind_param("i", $staff_id);
    $getStmt->execute();
    $getStmt->bind_result($last_name);
    $getStmt->fetch();
    $getStmt->close();

    // 2️⃣ Delete staff
    $stmt = $conn->prepare("DELETE FROM staff WHERE staff_id = ?");
    $stmt->bind_param("i", $staff_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Staff member '{$last_name}' has been deleted successfully!";
        $_SESSION['message_type'] = "danger";

    } else {
        $_SESSION['message'] = "Error deleting staff '{$last_name}'.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();

    header("Location: manage_staff.php");
    exit();
}
?>
