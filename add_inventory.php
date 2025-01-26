<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ABC_Company";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch company information
$company_name = "";
$address = "";
$sql = "SELECT company_name, address FROM company_info LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $company_name = $row['company_name'];
    $address = $row['address'];
} else {
    $company_name = "Default Company Name";
    $address = "Default Address";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .company-info {
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
        }

        main {
            padding: 20px;
        }

        .invoice-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        form {
            display: grid;
            grid-template-rows: repeat(3, auto);
            row-gap: 20px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row > div {
            flex: 1 1 calc(25% - 15px);
            min-width: 200px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input,
        form select,
        form button {
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 10%;
        }

        form button:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 60%;
        }

        @media (max-width: 768px) {
            .form-row > div {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        Purchase Invoice
    </header>
    <div class="company-info">
        <p><?php echo htmlspecialchars($company_name); ?></p>
        <p><?php echo htmlspecialchars($address); ?></p>
    </div>
    <main>
        <div class="invoice-container">
            <form action="process_invoice.php" method="POST">
                <!-- Row 1 -->
                <div class="form-row">
                    <div>
                        <label for="supplier_id">Supplier ID:</label>
                        <input type="text" id="supplier_id" name="supplier_id" placeholder="Enter supplier ID" required>
                    </div>
                    <div>
                        <label for="supplier_name">Supplier Name:</label>
                        <input type="text" id="supplier_name" name="supplier_name" placeholder="Enter supplier name" required>
                    </div>
                    <div>
                        <label for="invoice_no">Invoice No.:</label>
                        <input type="text" id="invoice_no" name="invoice_no" placeholder="Enter invoice number" required>
                    </div>
                    <div>
                        <label for="reference">Reference:</label>
                        <input type="text" id="reference" name="reference" placeholder="Enter reference" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-row">
                    
                    <div>
                        
                        <label for="item_name">Item Name:</label>
                        <input type="text" id="item_name" name="item_name" placeholder="Enter item name" required>
                    </div>
                    
                    <div>
                        <label for="uom">Unit of Measure (UOM):</label>
                        <input type="text" id="uom" name="uom" placeholder="Enter UOM (e.g., kg, pcs)" required>
                    </div>
                    <div>
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
                    </div>
                    <div>
                        <label for="unit_cost">Unit Cost:</label>
                        <input type="number" step="0.01" id="unit_cost" name="unit_cost" placeholder="Enter unit cost" required>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-row">
                    <div>
                        <label for="total_cost">Total Cost:</label>
                        <input type="number" step="0.01" id="total_cost" name="total_cost" placeholder="Total cost (calculated)" readonly>
                    </div>
                    <div>
                        <label for="vat">VAT:</label>
                        <input type="number" step="0.01" id="vat" name="vat" placeholder="Enter VAT" required>
                    </div>
                    <div>
                        <label for="withholding">Withholding:</label>
                        <input type="number" step="0.01" id="withholding" name="withholding" placeholder="Enter withholding" required>
                    </div>
                    <div>
                        <label for="branch">Branch:</label>
                        <select id="branch" name="branch" required>
                            <option value="" disabled selected>Select branch</option>
                            <option value="Branch1">Branch 1</option>
                            <option value="Branch2">Branch 2</option>
                            <option value="Branch3">Branch 3</option>
                        </select>
                    </div>
                </div>

                <!-- Account ID and Submit Button -->
                <div class="form-row">
                    <div style="flex: 1 1 50%;">
                        <label for="account_id">Account ID:</label>
                        <input type="text" id="account_id" name="account_id" placeholder="Enter account ID" required>
                    </div>
                    <div style="flex: 1 1 50%;">
                        <button type="submit">Save Invoice</button>
                    </div>
                </div>
                
            </form>
        </div>
        <!-- Row 2 -->
<div class="form-row">
    <div>
        <label for="item_id">Item ID:</label>
        <input type="text" id="item_id" name="item_id" placeholder="Enter item ID" required>
    </div>
    <div>
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" placeholder="Enter item name" required>
    </div>
    <div>
        <label for="uom">Unit of Measure (UOM):</label>
        <input type="text" id="uom" name="uom" placeholder="Enter UOM (e.g., kg, pcs)" required>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
    </div>
</div>

    </main>
    
    <footer>
        &copy; 2025 Inventory Management System
    </footer>
</body>
</html>
kkkkkkkkkkkkkk
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ABC_Company";

$conn = new mysqli($servername, $username, $password, $dbname);

// Generate invoice number
$invoice_number = "INV-" . date('Ymd') . "-" . str_pad(mt_rand(1,999), 3, '0', STR_PAD_LEFT);

// Fetch necessary data from database
$suppliers = $conn->query("SELECT id, name, address FROM suppliers");
$branches = $conn->query("SELECT id, branch_name FROM branches");
$items = $conn->query("SELECT item_id, item_name, uom, unit_cost FROM items");
$accounts = $conn->query("SELECT account_code, account_name FROM chart_of_accounts");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Advanced Purchase Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .invoice-box {
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #555;
        }
        .table-item td { padding: 3px !important; vertical-align: middle !important; }
        .autocomplete { position: relative; display: inline-block; }
        .autocomplete-items { position: absolute; z-index: 99; }
        .signature-box { border: 1px solid #ccc; height: 80px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="invoice-box">
    <form action="save_invoice.php" method="post" id="invoiceForm">
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>PURCHASE INVOICE</h2>
            <div class="form-group">
                <label>Supplier:</label>
                <select class="form-control" name="supplier_id" id="supplierSelect" required>
                    <option value="">Select Supplier</option>
                    <?php while($row = $suppliers->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div id="supplierInfo"></div>
        </div>
        
        <div class="col-md-6 text-right">
            <div class="form-group">
                <label>Invoice Number:</label>
                <input type="text" name="invoice_no" class="form-control" value="<?= $invoice_number ?>" readonly>
            </div>
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="invoice_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-group">
                <label>Branch:</label>
                <select class="form-control" name="branch_id" required>
                    <?php while($row = $branches->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['branch_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Cash Account:</label>
                <select class="form-control" name="cash_account" required>
                    <?php while($row = $accounts->fetch_assoc()): ?>
                    <option value="<?= $row['account_code'] ?>"><?= $row['account_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Reference:</label>
                <input type="text" name="reference" class="form-control">
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Description</th>
                <th>UOM</th>
                <th>Quantity</th>
                <th>Unit Cost</th>
                <th>Total Cost</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item-row">
                <td>
                    <select class="form-control item-select" name="item_id[]">
                        <option value="">Select Item</option>
                        <?php while($row = $items->fetch_assoc()): ?>
                        <option value="<?= $row['item_id'] ?>" 
                            data-uom="<?= $row['uom'] ?>" 
                            data-unitcost="<?= $row['unit_cost'] ?>">
                            <?= $row['item_name'] ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td><input type="text" name="description[]" class="form-control"></td>
                <td><input type="text" name="uom[]" class="form-control uom" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control qty" step="0.01"></td>
                <td><input type="number" name="unit_cost[]" class="form-control unit-cost" step="0.01"></td>
                <td><input type="number" name="total_cost[]" class="form-control total-cost" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">×</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" id="addRow">Add Item</button>

    <!-- Totals Section -->
    <div class="row mt-4">
        <div class="col-md-4 offset-md-8">
            <table class="table">
                <tr>
                    <th>Subtotal:</th>
                    <td><input type="number" name="subtotal" id="subtotal" class="form-control" readonly></td>
                </tr>
                <tr>
                    <th>Tax (%):</th>
                    <td><input type="number" name="tax_rate" id="taxRate" class="form-control" value="15" step="0.01"></td>
                </tr>
                <tr>
                    <th>Tax Amount:</th>
                    <td><input type="number" name="tax_amount" id="taxAmount" class="form-control" readonly></td>
                </tr>
                <tr>
                    <th>Grand Total:</th>
                    <td><input type="number" name="grand_total" id="grandTotal" class="form-control" readonly></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Approval Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="form-group">
                <label>Prepared By:</label>
                <input type="text" name="prepared_by" class="form-control" required>
                <div class="signature-box"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Checked By:</label>
                <input type="text" name="checked_by" class="form-control" required>
                <div class="signature-box"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Approved By:</label>
                <input type="text" name="approved_by" class="form-control" required>
                <div class="signature-box"></div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-lg btn-success">Save Invoice</button>
        <button type="button" class="btn btn-lg btn-primary" onclick="window.print()">Print</button>
    </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add new item row
    $('#addRow').click(function() {
        const newRow = $('.item-row:first').clone();
        newRow.find('input').val('');
        newRow.find('.total-cost').val('0.00');
        $('#itemsTable tbody').append(newRow);
    });

    // Remove item row
    $(document).on('click', '.remove-row', function() {
        if($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });

    // Item selection handler
    $(document).on('change', '.item-select', function() {
        const row = $(this).closest('tr');
        const selectedOption = $(this).find('option:selected');
        row.find('.uom').val(selectedOption.data('uom'));
        row.find('.unit-cost').val(selectedOption.data('unitcost'));
        calculateRowTotal(row);
    });

    // Quantity/unit cost change handler
    $(document).on('input', '.qty, .unit-cost', function() {
        calculateRowTotal($(this).closest('tr'));
    });

    function calculateRowTotal(row) {
        const qty = parseFloat(row.find('.qty').val()) || 0;
        const unitCost = parseFloat(row.find('.unit-cost').val()) || 0;
        const total = qty * unitCost;
        row.find('.total-cost').val(total.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        $('.total-cost').each(function() {
            subtotal += parseFloat($(this).val()) || 0;
        });
        
        const taxRate = parseFloat($('#taxRate').val()) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const grandTotal = subtotal + taxAmount;

        $('#subtotal').val(subtotal.toFixed(2));
        $('#taxAmount').val(taxAmount.toFixed(2));
        $('#grandTotal').val(grandTotal.toFixed(2));
    }
});
</script>
</body>
</html>
kkkkk

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ABC_Company";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Generate invoice number
    $invoice_number = "INV-" . date('Ymd') . "-" . str_pad(mt_rand(1,999), 3, '0', STR_PAD_LEFT);

    // Fetch data only if connection is successful
    $suppliers = $conn->query("SELECT id, name, address FROM suppliers");
    $branches = $conn->query("SELECT id, branch_name FROM branches");
    $items = $conn->query("SELECT item_id, item_name, uom, unit_cost FROM items");
    $accounts = $conn->query("SELECT account_code, account_name FROM chart_of_accounts");
    
    // Close connection after fetching data
    $conn->close();

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!-- Rest of your HTML/PHP code -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center">Invoice Form</h2>
    
    <!-- Start of the form -->
    <form id="invoice-form">
        <table class="table table-bordered" id="invoice-table">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Description</th>
                    <th>GL Account</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Sales</th>
                    <th>Job ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be added here -->
            </tbody>
        </table>

        <div class="mb-3 text-center">
            <button type="button" class="btn btn-success" onclick="addRow()">Add Row</button>
            <button type="button" class="btn btn-danger" onclick="removeRow()">Remove Last Row</button>
        </div>

        <div class="mb-3">
            <label for="total-sales" class="form-label">Total Sales (Before VAT)</label>
            <input type="text" class="form-control" id="total-sales" name="total_sales" readonly>
        </div>

        <!-- Section to display VAT and Total after VAT -->
        <div class="mb-3">
            <label for="vat" class="form-label">VAT (15%)</label>
            <input type="text" class="form-control" id="vat" name="vat" readonly>
        </div>

        <div class="mb-3">
            <label for="grand-total" class="form-label">Sales Total (After VAT)</label>
            <input type="text" class="form-control" id="grand-total" name="grand_total" readonly>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Save Sales</button>
        </div>
    </form>

    <!-- Section to display Summary Sales Details after Saving -->
    <div id="sales-summary" class="mt-5" style="display: none;">
        <h3>Sales Summary</h3>
        <p><strong>Total Sales (Before VAT):</strong> <span id="summary-total-sales"></span></p>
        <p><strong>VAT (15%):</strong> <span id="summary-vat"></span></p>
        <p><strong>Sales Total (After VAT):</strong> <span id="summary-grand-total"></span></p>
    </div>
</div>

<!-- Bootstrap 5 JS & Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
// Function to add a new row
function addRow() {
    const tableBody = document.querySelector('#invoice-table tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" class="form-control" name="item_id[]"></td>
        <td><input type="text" class="form-control" name="item_description[]"></td>
        <td><input type="text" class="form-control" name="gl_account[]"></td>
        <td><input type="number" class="form-control" name="quantity[]" oninput="calculateTotal()"></td>
        <td><input type="number" class="form-control" name="unit_price[]" oninput="calculateTotal()"></td>
        <td><input type="number" class="form-control" name="total_sales[]" readonly></td>
        <td><input type="text" class="form-control" name="job_id[]"></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
    `;
    
    tableBody.appendChild(row);
}

// Function to remove the last row
function removeRow(button) {
    const row = button.closest('tr');
    if (document.querySelectorAll('#invoice-table tbody tr').length > 1) {
        row.remove();
        calculateTotal();
    }
}

// Function to calculate totals (Before and After VAT)
function calculateTotal() {
    let totalSales = 0;

    // Get all rows in the table
    const rows = document.querySelectorAll('#invoice-table tbody tr');

    rows.forEach(row => {
        const quantity = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
        const unitPrice = parseFloat(row.querySelector('[name="unit_price[]"]').value) || 0;

        const total = quantity * unitPrice;

        // Set value for total sales before VAT
        row.querySelector('[name="total_sales[]"]').value = total.toFixed(2);

        totalSales += total;
    });

    // Calculate VAT (15%)
    const vat = totalSales * 0.15;
    const grandTotal = totalSales + vat;

    // Update the total sales, VAT, and grand total fields
    document.getElementById('total-sales').value = totalSales.toFixed(2);
    document.getElementById('vat').value = vat.toFixed(2);
    document.getElementById('grand-total').value = grandTotal.toFixed(2);
}

// Handle form submission
document.getElementById('invoice-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get the total sales, VAT, and grand total values
    const totalSales = parseFloat(document.getElementById('total-sales').value);
    const vat = parseFloat(document.getElementById('vat').value);
    const grandTotal = parseFloat(document.getElementById('grand-total').value);

    // Log values for debugging
    console.log("Total Sales (Before VAT):", totalSales);
    console.log("VAT (15%):", vat);
    console.log("Grand Total (After VAT):", grandTotal);

    // Check if the values are valid
    if (isNaN(totalSales) || isNaN(vat) || isNaN(grandTotal)) {
        alert("Please calculate the totals first.");
        return;
    }

    // Display the sales summary section
    document.getElementById('sales-summary').style.display = 'block';
    document.getElementById('summary-total-sales').textContent = totalSales.toFixed(2);
    document.getElementById('summary-vat').textContent = vat.toFixed(2);
    document.getElementById('summary-grand-total').textContent = grandTotal.toFixed(2);

    // Optionally, reset the form or perform further processing
});
</script>

</body>
</html>
