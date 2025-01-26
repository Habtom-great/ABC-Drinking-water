<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "abc_company");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $account_name = $_POST['account_name'];
    $contact_info = $_POST['contact_info'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $ledger_account = isset($_POST['ledger_account']) ? $_POST['ledger_account'] : '';

    if (empty($ledger_account)) {
        echo "<script>alert('Ledger Account is required.');</script>";
    } else {
        // Insert supplier into the suppliers table
        $supplier_query = "INSERT INTO suppliers (name, account_name, contact_info, phone, email, address, ledger_account) 
                           VALUES ('$supplier_name', '$account_name', '$contact_info', '$phone', '$email', '$address', '$ledger_account')";
        $result = mysqli_query($conn, $supplier_query);

        if ($result) {
            echo "<script>alert('Supplier added successfully!'); window.location.href='add_supplier.php';</script>";
        } else {
            echo "<script>alert('Error adding supplier: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-group {
                padding: auto;
          margin-top: 6px;
            margin-bottom: 10px;
        }
        .form-control {
            width: 300px; /* Smaller width for inputs */
        }
        .form-inline .form-group {
            margin-right: 15px; /* Spacing between inputs in one row */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Supplier</h2>
        <form method="POST" action="add_supplier.php" class="form-inline">
        <div class="form-group">
                <label for="supplier_id" class="mr-2">Supplier ID</label>
                <input type="text" name="supplier_id" class="form-control" id="supplier_id" required>
            </div> 
            <div class="form-group">
                <label for="supplier_name" class="mr-2">Supplier Name</label>
                <input type="text" name="supplier_name" class="form-control" id="supplier_name" required>
            </div>
            <div class="form-group">
                <label for="account_name" class="mr-2">Account Name</label>
                <input type="text" name="account_name" class="form-control" id="account_name">
            </div>
            <div class="form-group">
                <label for="contact_info" class="mr-2">Contact Info</label>
                <input type="text" name="contact_info" class="form-control" id="contact_info">
            </div>
            <div class="form-group">
                <label for="phone" class="mr-2">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone">
            </div>
            <div class="form-group">
                <label for="email" class="mr-2">Email</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="address" class="mr-2">Address</label>
                <input type="text" name="address" class="form-control" id="address">
            </div>
            <div class="form-group">
                <label for="ledger_account" class="mr-2">Ledger Account</label>
                <select name="ledger_account" class="form-control" id="ledger_account" required>
                    <option value="">Select Account</option>
                    <option value="Expense Account">Expense Account</option>
                    <option value="Liability Account">Liability Account</option>
                    <option value="Asset Account">Asset Account</option>
                </select>
            </div>
            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Add Supplier</button>
            </div>
        </form>
    </div>
</body>
</html>
