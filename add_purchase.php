<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_company";

$conn = new mysqli($servername, $username, password: $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$companyName = $_POST['Company_Name'] ?? '';
$address = $_POST['Address'] ?? '';
$date = $_POST['Date'] ?? '';
$invoiceNo = $_POST['Invoice_No'] ?? '';
$vat = is_numeric($_POST['VAT'] ?? null) ? floatval($_POST['VAT']) : 0;
$withhold = is_numeric($_POST['Withhold'] ?? null) ? floatval($_POST['Withhold']) : 0;
$subTotal = is_numeric($_POST['Sub_Total'] ?? null) ? floatval($_POST['Sub_Total']) : 0;
$netTotal = is_numeric($_POST['Net_Total'] ?? null) ? floatval($_POST['Net_Total']) : 0;
$netTotalWords = $_POST['Net_Total_in_Words'] ?? '';

// Calculate VAT amount
$vatAmount = $subTotal * ($vat / 100);

// Format numbers
$subTotalFormatted = number_format($subTotal, 2);
$vatAmountFormatted = number_format($vatAmount, 2);
$withholdFormatted = number_format($withhold, 2);
$netTotalFormatted = number_format($netTotal, 2);

// Fetch items
$items = [];
if (isset($_POST['Items']) && is_array($_POST['Items'])) {
    foreach ($_POST['Items'] as $item) {
        $items[] = [
            'Item ID' => $item['Item_ID'] ?? '',
            'Description' => $item['Description'] ?? '',
            'UoM' => $item['UoM'] ?? '',
            'Quantity' => is_numeric($item['Quantity'] ?? null) ? floatval($item['Quantity']) : 0,
            'Unit Cost' => is_numeric($item['Unit_Cost'] ?? null) ? floatval($item['Unit_Cost']) : 0,
            'Total Cost' => is_numeric($item['Total_Cost'] ?? null) ? floatval($item['Total_Cost']) : 0,
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Purchase Invoice</title>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
 <style>
 body {
  background-color: #f8f9fa;
  font-family: Arial, sans-serif;
 }

 .container {
  max-width: 900px;
  margin: 20px auto;
  background: #fff;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
 }

 h1,
 h2 {
  text-align: center;
  margin-bottom: 20px;
 }

 table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
 }

 table th,
 table td {
  border: 1px solid #dee2e6;
  padding: 10px;
  text-align: center;
 }

 table th {
  background-color: #f1f1f1;
 }

 .signature {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
 }

 .signature div {
  width: 30%;
  text-align: center;
 }
 </style>
</head>

<body>
 <div class="container">
  <h1>Purchase Invoice</h1>

  <h2>Company Information</h2>
  <p><strong>Company Name:</strong> <?= htmlspecialchars($companyName) ?></p>
  <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
  <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
  <p><strong>Invoice No:</strong> <?= htmlspecialchars($invoiceNo) ?></p>

  <h2>Items</h2>
  <table class="table table-bordered">
   <thead>
    <tr>
     <th>Item ID</th>
     <th>Description</th>
     <th>UoM</th>
     <th>Quantity</th>
     <th>Unit Cost</th>
     <th>Total Cost</th>
    </tr>
   </thead>
   <tbody>
    <?php if (!empty($items)): ?>
    <?php foreach ($items as $item): ?>
    <tr>
     <td><?= htmlspecialchars($item['Item ID']) ?></td>
     <td><?= htmlspecialchars($item['Description']) ?></td>
     <td><?= htmlspecialchars($item['UoM']) ?></td>
     <td><?= number_format($item['Quantity'], 2) ?></td>
     <td>$<?= number_format($item['Unit Cost'], 2) ?></td>
     <td>$<?= number_format($item['Total Cost'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
     <td colspan="6">No items found.</td>
    </tr>
    <?php endif; ?>
   </tbody>
  </table>

  <h2>Summary</h2>
  <p><strong>Subtotal:</strong> $<?= $subTotalFormatted ?></p>
  <p><strong>VAT (<?= $vat ?>%):</strong> $<?= $vatAmountFormatted ?></p>
  <p><strong>Withhold:</strong> $<?= $withholdFormatted ?></p>
  <p><strong>Net Total:</strong> $<?= $netTotalFormatted ?> (<?= htmlspecialchars($netTotalWords) ?>)</p>

  <div class="signature">
   <div>
    <p>Prepared By:</p>
    <p>____________________</p>
   </div>
   <div>
    <p>Checked By:</p>
    <p>____________________</p>
   </div>
   <div>
    <p>Approved By:</p>
    <p>____________________</p>
   </div>
  </div>
 </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
kkkkkkkkkkkkkkkk

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Add Purchase</title>
 <!-- Bootstrap CSS -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
 <!-- Custom CSS -->


<body>
 <div class="header">
  <h1>Purchase Management</h1>
  <nav>
   <a href="dashboard.php">Dashboard</a> |
   <a href="invoices.php">Invoices</a> |
   <a href="orders.php">Orders</a> |
   <a href="ledger.php">Ledger Accounts</a>
  </nav>
 </div>

 <div class="container">
  <h2 class="text-center">Add Purchase</h2>
  <form id="purchaseForm" action="process_purchase.php" method="POST">
   <!-- Supplier and Purchase Date -->
   <div class="row mb-3">
    <div class="col-md-2">
     <label for="supplierName" class="form-label">Supplier Name</label>
     <select id="supplierName" name="supplierName" class="form-select">
      <option>Select Supplier</option>
      <option>Supplier A</option>
      <option>Supplier B</option>
     </select>
    </div>
    <div class="col-md-2">
     <label for="purchaseDate" class="form-label">Purchase Date</label>
     <input type="date" id="purchaseDate" name="purchaseDate" class="form-control">
    </div>
   </div>

   <!--  Reference No -->


   <div class="col-md-2">
    <label for="referenceNo" class="form-label">Reference No.</label>
    <input type="text" id="referenceNo" name="referenceNo" class="form-control">
   </div>


   <!-- Ledger Account -->
   <div class="row mb-3">
    <div class="col-md-2">
     <label for="ledgerAccount" class="form-label">Ledger Account</label>
     <select id="ledgerAccount" name="ledgerAccount" class="form-select">
      <option>Select Ledger Account</option>
      <option>Cash/Bank</option>
      <option>Accounts Payable</option>
      <option>Expense Account</option>
      <option>Liability Account</option>
     </select>
    </div>
   </div>

   <!-- Invoice, Order, and Purchase Nos -->
   <div class="row mb-3">
    <div class="col-md-2">
     <label for="invoice_no" class="form-label">Invoice No:</label>
     <input type="text" id="invoice_no" name="invoice_no" class="form-control" placeholder="Enter invoice number">
    </div>
    <div class="col-md-2">
     <label for="order_no" class="form-label">Order No:</label>
     <input type="text" id="order_no" name="order_no" class="form-control" placeholder="Enter order number">
    </div>
    <div class="col-md-2">
     <label for="purchase_no" class="form-label">Purchase No:</label>
     <input type="text" id="purchase_no" name="purchase_no" class="form-control" placeholder="Enter purchase number">
    </div>
   </div>

   <!-- Item Type, UOM, GL Accounts -->
   <div class="row mb-2">
    <div class="col-md-2">
     <label for="item_type" class="form-label">Item Type:</label>
     <select id="item_type" name="item_type" class="form-select">
      <option value="">Select Item Type</option>
      <option value="item">Item</option>
      <option value="service">Service</option>
     </select>
    </div>
    <div class="col-md-2">
     <label for="uom" class="form-label">Unit of Measure (UOM):</label>
     <select id="uom" name="uom" class="form-select">
      <option value="">Select UOM</option>
      <option value="piece">Piece</option>
      <option value="kg">Kilogram</option>
      <option value="litre">Litre</option>
     </select>
    </div>
    <div class="col-md-2">
     <label for="gl_sales" class="form-label">GL Sales Account:</label>
     <input type="text" id="gl_sales" name="gl_sales" class="form-control" placeholder="Enter GL sales account">
    </div>
   </div>

   <!-- GL Inventory, Cost of Sales, Location, Discount -->
   <div class="row mb-2">
    <div class="col-md-2">
     <label for="gl_inventory" class="form-label">GL Inventory Account:</label>
     <input type="text" id="gl_inventory" name="gl_inventory" class="form-control"
      placeholder="Enter GL inventory account">
    </div>
    <div class="col-md-2">
     <label for="gl_cost_of_sales" class="form-label">GL Cost of Sales:</label>
     <input type="text" id="gl_cost_of_sales" name="gl_cost_of_sales" class="form-control"
      placeholder="Enter GL cost of sales account">
    </div>
    <div class="col-md-2">
     <label for="location" class="form-label">Location:</label>
     <input type="text" id="location" name="location" class="form-control" placeholder="Enter location">
    </div>
   </div>

   <!-- Discount and Description -->
   <div class="row mb-2">
    <div class="col-md-2">
     <label for="discount" class="form-label">Discount (%):</label>
     <input type="number" id="discount" name="discount" class="form-control" placeholder="Enter discount" step="0.01"
      min="0" max="100">
    </div>
    <div class="col-md-2">
     <label for="description" class="form-label">Description:</label>
     <textarea id="description" name="description" rows="4" class="form-control"
      placeholder="Enter purchase details"></textarea>
    </div>
   </div>

   <!-- Table for Items -->
   <div class="table-responsive">
    <table class="table table-bordered">
     <thead>
      <tr>
       <th>Item ID</th>
       <th>Item Description</th>
       <th>Quantity</th>
       <th>Unit Price ($)</th>
       <th>Discount ($)</th>
       <th>Sub Total</th>
       <th>VAT Tax (%)</th>
       <th>Sub Total Cost ($)</th>
       <th>withholdingTax (%)</th>
       <th>Action</th>
      </tr>
     </thead>
     <tbody>
      <tr>
       <td><input type="text" name="product[]" class="form-control"></td>
       <td><input type="number" name="quantity[]" class="form-control" oninput="calculateTotal(this)"></td>
       <td><input type="number" name="unit_price[]" class="form-control" oninput="calculateTotal(this)"></td>
       <td><input type="number" name="discount[]" class="form-control" oninput="calculateTotal(this)"></td>
       <td><input type="number" name="tax[]" class="form-control" oninput="calculateTotal(this)"></td>
       <td><input type="number" name="total_cost[]" class="form-control" readonly></td>
       <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
      </tr>
     </tbody>
    </table>
   </div>

   <div class="text-center">
    <button type="submit" class="btn btn-submit">Submit</button>
    <button type="button" class="btn btn-cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
   </div>
  </form>

  <div class="signature">
   <div>
    <p>Prepared By:</p>
    <p>____________________</p>
   </div>
   <div>
    <p>Checked By:</p>
    <p>____________________</p>
   </div>
   <div>
    <p>Approved By:</p>
    <p>____________________</p>
   </div>
  </div>
 </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
</div>

<div class="footer">
 <p>&copy; 2025 ABC company. All Rights Reserved.</p>
</div>


<!-- JavaScript -->
<script>
// Function to calculate the total cost
function calculateTotal(input) {
 const row = input.closest('tr');
 const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
 const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
 const discount = parseFloat(row.querySelector('input[name="discount[]"]').value) || 0;
 const tax = parseFloat(row.querySelector('input[name="tax[]"]').value) || 0;

 // Calculate total cost
 const discountAmount = (discount / 100) * (quantity * unitPrice);
 const taxAmount = (tax / 100) * (quantity * unitPrice);
 const totalCost = (quantity * unitPrice) - discountAmount + taxAmount;

 row.querySelector('input[name="total_cost[]"]').value = totalCost.toFixed(2);
}

// Function to delete a row
function deleteRow(button) {
 const row = button.closest('tr');
 row.remove();
}
</script>
</body>


<div class="col-md-6">
 <label for="purchaseDate" class="form-label">Purchase Date</label>
 <input type="date" id="purchaseDate" name="purchaseDate" class="form-control">
</div>
</div>

<!-- Product Name and Reference No -->
<div class="row mb-3">
 <div class="col-md-6">
  <label for="itemDescription" class="form-label">Item Description</label>
  <select id="itemDescription" name="itemDescription" class="form-select">
   <option>Select Item</option>
   <option>Item A</option>
   <option>Item B</option>
  </select>
 </div>
 <div class="col-md-6">
  <label for="referenceNo" class="form-label">Reference No.</label>
  <input type="text" id="referenceNo" name="referenceNo" class="form-control">
 </div>
</div>

<!-- Ledger Account -->
<div class="row mb-3">
 <div class="col-md-12">
  <label for="ledgerAccount" class="form-label">Ledger Account</label>
  <select id="ledgerAccount" name="ledgerAccount" class="form-select">
   <option>Select Ledger Account</option>
   <option>Cash/Bank</option>
   <option>Accounts Payable</option>
   <option>Expense Account</option>
   <option>Liability Account</option>
  </select>
 </div>
</div>

<!-- Invoice, Order, and Purchase Nos -->
<div class="row mb-3">
 <div class="col-md-4">
  <label for="invoice_no" class="form-label">Invoice No:</label>
  <input type="text" id="invoice_no" name="invoice_no" class="form-control" placeholder="Enter invoice number">
 </div>
 <div class="col-md-4">
  <label for="order_no" class="form-label">Order No:</label>
  <input type="text" id="order_no" name="order_no" class="form-control" placeholder="Enter order number">
 </div>
 <div class="col-md-4">
  <label for="purchase_no" class="form-label">Purchase No:</label>
  <input type="text" id="purchase_no" name="purchase_no" class="form-control" placeholder="Enter purchase number">
 </div>
</div>

<!-- Item Type, UOM, GL Accounts -->
<div class="row mb-3">
 <div class="col-md-4">
  <label for="item_type" class="form-label">Item Type:</label>
  <select id="item_type" name="item_type" class="form-select">
   <option value="">Select Item Type</option>
   <option value="item">Item</option>
   <option value="service">Service</option>
  </select>
 </div>
 <div class="col-md-4">
  <label for="uom" class="form-label">Unit of Measure (UOM):</label>
  <select id="uom" name="uom" class="form-select">
   <option value="">Select UOM</option>
   <option value="piece">Piece</option>
   <option value="kg">Kilogram</option>
   <option value="litre">Litre</option>
  </select>
 </div>
 <div class="col-md-4">
  <label for="gl_sales" class="form-label">GL Sales Account:</label>
  <input type="text" id="gl_sales" name="gl_sales" class="form-control" placeholder="Enter GL sales account">
 </div>
</div>

<!-- GL Inventory, Cost of Sales, Location, Discount -->
<div class="row mb-3">
 <div class="col-md-4">
  <label for="gl_inventory" class="form-label">GL Inventory Account:</label>
  <input type="text" id="gl_inventory" name="gl_inventory" class="form-control"
   placeholder="Enter GL inventory account">
 </div>
 <div class="col-md-4">
  <label for="gl_cost_of_sales" class="form-label">GL Cost of Sales:</label>
  <input type="text" id="gl_cost_of_sales" name="gl_cost_of_sales" class="form-control"
   placeholder="Enter GL cost of sales account">
 </div>
 <div class="col-md-4">
  <label for="location" class="form-label">Location:</label>
  <input type="text" id="location" name="location" class="form-control" placeholder="Enter location">
 </div>
</div>

<!-- Discount and Description -->
<div class="row mb-3">
 <div class="col-md-6">
  <label for="discount" class="form-label">Discount (%):</label>
  <input type="number" id="discount" name="discount" class="form-control" placeholder="Enter discount" step="0.01"
   min="0" max="100">
 </div>
 <div class="col-md-6">
  <label for="description" class="form-label">Description:</label>
  <textarea id="description" name="description" rows="4" class="form-control"
   placeholder="Enter purchase details"></textarea>
 </div>
</div>

<!-- Table for Items -->
<div class="table-responsive">
 <table class="table table-bordered">
  <thead>

   <!-- Item Description  -->
   <div class="row mb-3">
    <div class="col-md-6">
     <label for="itemDescription" class="form-label">Item Description</label>
     <select id="itemDescription" name="itemDescription" class="form-select">
      <option>Select Item</option>
      <option>Item A</option>
      <option>Item B</option>
     </select>
    </div>
    <tr>
     <th>Item ID</th>
     <th>Item Description</th>
     <th>Quantity</th>
     <th>Unit Price ($)</th>
     <th>Discount ($)</th>
     <th>Sub Total ($)</th>
     <th>VAT (15%)</th>
     <th>Withholding Tax (2%)</th>
     <th>Total Cost ($)</th>
     <th>Action</th>
    </tr>
  </thead>
  <tbody>
   <tr>
    <td><input type="text" name="item_id[]" class="form-control"></td>
    <td><input type="text" name="item_description[]" class="form-control"></td>
    <td><input type="number" name="quantity[]" class="form-control" oninput="calculateTotal(this)"></td>
    <td><input type="number" name="unit_price[]" class="form-control" oninput="calculateTotal(this)"></td>
    <td><input type="number" name="discount[]" class="form-control" oninput="calculateTotal(this)"></td>
    <td><input type="text" name="sub_total[]" class="form-control" readonly></td>
    <td><input type="text" name="vat[]" class="form-control" readonly></td>
    <td><input type="text" name="withholding_tax[]" class="form-control" readonly></td>
    <td><input type="text" name="total_cost[]" class="form-control" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
   </tr>
  </tbody>
 </table>
</div>

<!-- Add Row Button -->
<div class="text-center mb-3">
 <button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button>
</div>

<!-- Submit Buttons -->
<div class="text-center">
 <button type="submit" class="btn btn-submit">Submit</button>
 <button type="button" class="btn btn-cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
</div>
</form>
</div>

<div class="footer">
 <p>&copy; 2025 ABC Company. All Rights Reserved.</p>
</div>

<!-- JavaScript -->
<script>
function calculateTotal(input) {
 const row = input.closest('tr');
 const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
 const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
 const discount = parseFloat(row.querySelector('input[name="discount[]"]').value) || 0;

 const subTotal = (quantity * unitPrice) - discount;
 const vat = subTotal * 0.15; // VAT at 15%
 const withholdingTax = subTotal * 0.02; // Withholding Tax at 2%
 const totalCost = subTotal + vat - withholdingTax;

 row.querySelector('input[name="sub_total[]"]').value = subTotal.toFixed(2);
 row.querySelector('input[name="vat[]"]').value = vat.toFixed(2);
 row.querySelector('input[name="withholding_tax[]"]').value = withholdingTax.toFixed(2);
 row.querySelector('input[name="total_cost[]"]').value = totalCost.toFixed(2);
}

function addRow() {
 const table = document.querySelector('tbody');
 const newRow = table.rows[0].cloneNode(true);
 newRow.querySelectorAll('input').forEach(input => input.value = '');
 table.appendChild(newRow);
}

function deleteRow(button) {
 const row = button.closest('tr');
 row.remove();
}
</script>
</body>

</html>
<style>
body {
 font-family: Arial, sans-serif;
 background: color #ffdab9(255, 218, 185);
}

.container {
 max-width: 900px;
 margin: 20px auto;
 background: #fff;
 padding: 20px;
 border-radius: 8px;
 box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header,
.footer {
 background-color: #343a40;
 color: #fff;
 padding: 10px 20px;
 text-align: center;
}

.header a,
.footer a {
 color: #ffc107;
 text-decoration: none;
}

.form-label {
 font-weight: bold;
}

.btn-submit {
 background-color: rgb(40, 167, 69);
 color: #FFE4B5;
}

.btn-cancel {
 background-color: #FFDAB9;
 color: #fff;
}

table {
 margin-top: 20px;
}

textarea {
 resize: none;
}

/* Style for responsive tables */
.table-responsive {
 overflow-x: auto;
}

.form-group {
 margin-bottom: 1.5rem;
}

/* Style for table row inputs */
.form-control,
.form-select {
 width: 100%;
}

/* Styling for delete button */
.btn-danger {
 margin-top: 5px;
}
</style>

kkkkkkkkkkk