<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

// Check invoice ID
if (!isset($_GET['invoice_id'])) {
    die("No invoice ID provided.");
}

$invoice_id = intval($_GET['invoice_id']);

// Fetch invoice info
$stmt = $conn->prepare("SELECT * FROM invoices WHERE id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$invoice_result = $stmt->get_result();

if ($invoice_result->num_rows === 0) {
    die("Invoice not found.");
}

$invoice = $invoice_result->fetch_assoc();

// Fetch invoice items
$item_stmt = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
$item_stmt->bind_param("i", $invoice_id);
$item_stmt->execute();
$item_result = $item_stmt->get_result();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['qty'] as $item_id => $qty) {
        $qty = intval($qty);
        $unit_cost = floatval($_POST['unit_cost'][$item_id]);
        $subtotal = $qty * $unit_cost;
        $vat = $subtotal * 0.15; // 15% VAT example
        $total = $subtotal + $vat;

        $update_stmt = $conn->prepare("
            UPDATE invoice_items 
            SET quantity = ?, unit_cost = ?, subtotal = ?, vat = ?, total = ? 
            WHERE id = ?
        ");
        $update_stmt->bind_param("iddddi", $qty, $unit_cost, $subtotal, $vat, $total, $item_id);
        $update_stmt->execute();
    }
    $success = "Invoice items updated successfully!";
    // Refresh items
    $item_stmt->execute();
    $item_result = $item_stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Invoice #<?= htmlspecialchars($invoice['id']) ?></title>
<link rel="stylesheet" href="style.css">
<style>
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
.alert { padding: 10px; margin-bottom: 10px; }
.alert-success { background: #d4edda; color: #155724; }
.alert-danger { background: #f8d7da; color: #721c24; }
</style>
</head>
<body>
<div class="container">
    <h2>Edit Invoice #<?= $invoice['id'] ?></h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $item_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_id']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td>
                        <input type="number" name="qty[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="0" required>
                    </td>
                    <td>
                        <input type="number" name="unit_cost[<?= $item['id'] ?>]" value="<?= $item['unit_cost'] ?>" step="0.01" min="0" required>
                    </td>
                    <td><?= number_format($item['subtotal'], 2) ?></td>
                    <td><?= number_format($item['vat'], 2) ?></td>
                    <td><?= number_format($item['total'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <button type="submit">Update Invoice</button>
        <a href="invoice_list.php">Back to Invoice List</a>
    </form>
</div>
</body>
</html>
