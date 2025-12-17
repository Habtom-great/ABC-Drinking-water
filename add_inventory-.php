<body>
 <div class="container my-4">
  <h1 class="text-center">ABC Company</h1>
  <h1 class="text-center">Purchase Invoice</h1>
  <h6 class="text-center">
   <Address> Bole , XXXXXX,Telephone , email </Address>
  </h6>

  <!-- Display success or error message -->
  <?php if (isset($success_message)): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
  <?php elseif (isset($error_message)): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
  <?php endif; ?>

  <!-- Sale Form -->
  <div class="card p-4">
   <form action="add_inventory.php" method="POST" id="purchase_form">
    <!-- Sales General Information in One Row -->
    <div class="row row-input">
     <div class="col-md-2">
      <label for="purchase_order_no" class="form-label">purchase Order No.</label>
      <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no">
     </div>
     <div class="col-md-2">
      <label for="purchase_invoice_no" class="form-label">Purchase Invoice No.</label>
      <input type="text" class="form-control" id="purchase_invoice_no" name="purchase_invoice_no" required>
     </div>
     <div class="col-md-2">
      <label for="reference" class="form-label">Reference</label>
      <input type="text" class="form-control" id="reference" name="reference" required>
     </div>

     <div class="col-md-2">
      <label for="invoiceDate" class="form-label">Invoice Date:</label>
      <input type="date" class="form-control" id="invoiceDate" required>
     </div>

     <!-- Customer Information in One Row -->
     <div class="row row-input">

      <div class="col-md-2">
       <label for="customer_id" class="form-label">Customer ID</label>
       <input type="text" class="form-control" id="customer_id" name="customer_id" required>
      </div>
      <div class="col-md-2">
       <label for="customer_Company_name" class="form-label">Customer Company Name</label>
       <input type="text" class="form-control" id="customer_company_name" name="customer_company_name" required>
      </div>
      <div class="col-md-3">
       <label for="customer_name" class="form-label">Customer Name</label>
       <input type="text" class="form-control" id="customer_name" name="customer_name" required>
      </div>
      <div class="col-md-2">
       <label for="customer_TIN No." class="form-label">Customer TIN No</label>
       <input type="text" class="form-control" id="customer_TIN No" name="customer_TIN No" required>
      </div>
      <div class="col-md-2">
       <label for="customer_Telephone No." class="form-label">Customer Telephone No</label>
       <input type="text" class="form-control" id="customer_Telephone No." name="customer_Telephone No." required>
      </div>
      <div class="row row-input">
       <div class="col-md-2">
        <label for="salesperson_id" class="form-label">Sales Person ID</label>
        <input type="text" class="form-control" id="salesperson_id" name="salesperson_id" required>
       </div>

       <div class="col-md-2">
        <label for="salesperson_name" class="form-label">Sales Person Name</label>
        <input type="text" class="form-control" id="salesperson_name" name="salesperson_name" required>
       </div>
       <div class="col-md-2">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-control" id="payment_method" name="payment_method" required>
         <option value="cash">Cash</option>
         <option value="cash">Cheque</option>
         <option value="bank">Bank Transfer</option>
         <option value="cash">Other</option>
        </select>
       </div>
      </div>

      <!-- Item Details Table (Excel-style) -->

      <script>
      function calculateTotal(input) {
       const row = input.closest("tr");
       const quantity = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
       const unitPrice = parseFloat(row.querySelector('[name="unit_price[]"]').value) || 0;
       const totalSales = quantity * unitPrice;
       row.querySelector('[name="total_sales[]"]').value = totalSales.toFixed(2);
       updateSalesSummary();
      }

      function addRow() {
       const table = document.getElementById("item_table").getElementsByTagName("tbody")[0];
       const newRow = table.insertRow();

       newRow.innerHTML = `
                <td><input type="text" class="form-control" name="item_id[]" required></td>
                <td><input type="text" class="form-control" name="item_description[]" required></td>
                <td><input type="text" class="form-control" name="gl_account[]" required></td>
                <td><input type="number" class="form-control" name="quantity[]" step="1" min="1" oninput="calculateTotal(this)" required></td>
                <td><input type="number" class="form-control" name="unit_price[]" step="0.01" min="0.01" oninput="calculateTotal(this)" required></td>
                <td><input type="number" class="form-control" name="total_sales[]" readonly></td>
                <td><input type="text" class="form-control" name="job_id[]"></td>
                <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
            `;
      }

      function removeRow(button) {
       const row = button.closest("tr");
       row.remove();
       updateSalesSummary();
      }

      function updateSalesSummary() {
       let totalBeforeVAT = 0;
       document.querySelectorAll('[name="total_sales[]"]').forEach(input => {
        totalBeforeVAT += parseFloat(input.value) || 0;
       });

       const vatAmount = totalBeforeVAT * 0.15;
       const totalWithVAT = totalBeforeVAT + vatAmount;

       document.getElementById("total_sales_before_vat").textContent = totalBeforeVAT.toFixed(2);
       document.getElementById("vat_amount").textContent = vatAmount.toFixed(2);
       document.getElementById("sales_with_vat").textContent = totalWithVAT.toFixed(2);

       document.getElementById("amount_in_words").textContent = `Total in Words: ${toWords(totalWithVAT)} Birr only.`;
      }

      function toWords(amount) {
       const ones = [
        "", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine",
        "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen",
        "Seventeen", "Eighteen", "Nineteen",
       ];
       const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
       const scales = ["", "Thousand", "Million", "Billion"];

       if (amount === 0) return "Zero";

       const words = [];
       const numStr = Math.floor(amount).toString();
       const numParts = numStr.match(/.{1,3}(?=(.{3})*$)/g).reverse();

       numParts.forEach((part, index) => {
        if (parseInt(part) === 0) return;

        let str = "";
        const hundreds = Math.floor(part / 100);
        const remainder = part % 100;
        if (hundreds > 0) str += ones[hundreds] + " Hundred ";
        if (remainder < 20) str += ones[remainder];
        else str += tens[Math.floor(remainder / 10)] + " " + ones[remainder % 10];

        words.push(str + (scales[index] ? " " + scales[index] : ""));
       });

       return words.reverse().join(" ").trim();
      }
      </script>
      </head>

      <body>
       <div class="container mt-3">


        <table id="item_table" class="table table-bordered">
         <thead>
          <tr>
           <th>Item ID</th>
           <th>Description</th>
           <th>GL Account</th>
           <th>Quantity</th>
           <th>Unit Price</th>
           <th>Total Sales</th>
           <th>Job ID</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <!-- Rows will be added dynamically -->
         </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-4" onclick="addRow()">Add Item</button>

        <div>
         <p><strong>Total Before VAT:</strong> Birr <span id="total_sales_before_vat"> 0.00</span></p>
         <p><strong>VAT (15%):</strong> Birr <span id="vat_amount"> 0.00</span></p>
         <p><strong>Total Sales with VAT:</strong> Birr <span id="sales_with_vat"> 0.00</span></p>
         <p id="amount_in_words"><strong>Total in Words: </strong> Zero Birr only.</p>
        </div>
       </div>


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


     <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary">Save Purchase</button>
     </div>


</body>

</html>

kkkkkkkkkkkkkkk
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ABC_Company");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Function to execute queries safely
function executeQuery($conn, $sql) {
    return $conn->query($sql);
}

// Ensure the company_info table exists
$sql = "SHOW TABLES LIKE 'company_info'";
$tableExists = executeQuery($conn, $sql)->num_rows > 0;

if (!$tableExists) {
    $createTable = "CREATE TABLE company_info (
        id INT PRIMARY KEY AUTO_INCREMENT,
        company_name VARCHAR(255) NOT NULL,
        address TEXT NOT NULL
    )";
    executeQuery($conn, $createTable);
}

// Fetch company info
$sql = "SELECT company_name, address FROM company_info LIMIT 1";
$result = executeQuery($conn, $sql);

$company_name = "Default Company Name";
$address = "Default Address";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $company_name = $row['company_name'];
    $address = $row['address'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory & Invoice System</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
 body {
  background-color: #f4f7fc;
  font-family: Arial, sans-serif;
 }

 .invoice-container {
  max-width: 900px;
  margin: 3rem auto;
  background: #ffffff;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
 }

 .card-header {
  background: linear-gradient(135deg, #4c8bf5, #1c39bb);
  color: white;
  text-align: center;
  font-size: 1.5rem;
 }

 .table thead {
  background: #343a40;
  color: white;
 }

 .total-display {
  background-color: #e9ecef;
  padding: 1rem;
  border-radius: 5px;
  font-size: 1.2rem;
 }
 </style>
</head>

<body>
 <div class="container invoice-container">
  <form method="POST">
   <div class="card shadow">
    <div class="card-header">
     <h3>Inventory & Invoice System</h3>
    </div>
    <div class="card-body">
     <div class="row mb-3">
      <div class="col-md-6">
       <label>Invoice Number</label>
       <input type="text" name="invoice_no" class="form-control" required>
      </div>
      <div class="col-md-6">
       <label>Reference</label>
       <input type="text" name="reference" class="form-control">
      </div>
     </div>

     <table class="table table-bordered">
      <thead>
       <tr>
        <th>Item</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
       </tr>
      </thead>
      <tbody id="items-container">
       <tr class="dynamic-row">
        <td><input type="text" name="items[][description]" class="form-control" required></td>
        <td><input type="number" name="items[][unit_price]" class="form-control price" required
          oninput="calculateTotal(this)"></td>
        <td><input type="number" name="items[][quantity]" class="form-control qty" required
          oninput="calculateTotal(this)"></td>
        <td><input type="number" name="items[][total_price]" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">×</button></td>
       </tr>
      </tbody>
     </table>

     <button type="button" class="btn btn-secondary" onclick="addItemRow()">Add Item</button>
    </div>

    <div class="card-footer text-end">
     <div class="total-display">
      <strong>Total: $<span id="grand-total">0.00</span></strong>
     </div>
     <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </div>
   </div>
  </form>
 </div>

 <script>
 function addItemRow() {
  let row = document.createElement('tr');
  row.innerHTML =
   `<td><input type="text" name="items[][description]" class="form-control" required></td>
    <td><input type="number" name="items[][unit_price]" class="form-control price" required oninput="calculateTotal(this)"></td>
    <td><input type="number" name="items[][quantity]" class="form-control qty" required oninput="calculateTotal(this)"></td>
    <td><input type="number" name="items[][total_price]" class="form-control total" readonly></td>
    <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">×</button></td>`;
  document.getElementById('items-container').appendChild(row);
 }

 function removeRow(button) {
  button.closest('tr').remove();
  updateGrandTotal();
 }

 function calculateTotal(input) {
  let row = input.closest('tr');
  let price = parseFloat(row.querySelector('.price').value) || 0;
  let qty = parseFloat(row.querySelector('.qty').value) || 0;
  let totalField = row.querySelector('.total');

  let total = price * qty;
  totalField.value = total.toFixed(2);

  updateGrandTotal();
 }

 function updateGrandTotal() {
  let grandTotal = 0;
  document.querySelectorAll('.total').forEach(totalField => {
   grandTotal += parseFloat(totalField.value) || 0;
  });
  document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
 }
 </script>

</body>

</html>