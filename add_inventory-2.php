<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "abc_company"; // change this
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $product_names = $_POST['product_name'];
  $quantities = $_POST['quantity'];
  $prices = $_POST['price'];
  $totals = $_POST['total'];

  $image_folder = "uploads/";
  if (!file_exists($image_folder)) {
    mkdir($image_folder, 0777, true);
  }

  for ($i = 0; $i < count($product_names); $i++) {
    $name = $conn->real_escape_string($product_names[$i]);
    $qty = (int)$quantities[$i];
    $price = (float)$prices[$i];
    $total = (float)$totals[$i];

    // Handle file
    $image_name = $_FILES['product_image']['name'][$i];
    $tmp_name = $_FILES['product_image']['tmp_name'][$i];
    $target = $image_folder . basename($image_name);

    if (move_uploaded_file($tmp_name, $target)) {
      $stmt = $conn->prepare("INSERT INTO inventory (product_name, quantity, price, total, image) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sidss", $name, $qty, $price, $total, $image_name);
      $stmt->execute();
    }
  }

  $success = true;
}
?>

<!DOCTYPE html>
<html>

<head>
 <title>Add Inventory</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <style>
 .message-success {
  background-color: #d4edda;
  color: #155724;
  border: 2px solid #c3e6cb;
  border-radius: 6px;
  padding: 12px;
  margin-bottom: 15px;
  font-weight: bold;
  text-align: center;
 }
 </style>
</head>

<body class="p-4">

 <?php if ($success): ?>
 <div class="message-success">
  ✅ Inventory added successfully!
 </div>
 <?php endif; ?>

 <a href="your_inventory_form_page.php" class="btn btn-primary">← Back to Inventory Form</a>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <title>Inventory Entry Form</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
 body {
  background: #f7f9fb;
  padding: 2rem;
 }

 .form-section {
  margin-bottom: 2rem;
 }

 .card-header {
  background-color: #0d6efd;
  color: white;
 }

 .table input {
  min-width: 120px;
 }
 </style>
</head>

<body>

 <div class="container">
  <h2 class="text-center mb-4 text-primary">Inventory & Purchase Entry Form</h2>

  <form action="add_inventory.php" method="POST" enctype="multipart/form-data" id="purchase_form">

   <!-- Purchase Info -->
   <div class="card form-section">
    <div class="card-header">Purchase Information</div>
    <div class="card-body row g-3">
     <div class="col-md-4">
      <label class="form-label">Invoice No.</label>
      <input type="text" name="invoice_no" class="form-control" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Reference</label>
      <input type="text" name="reference" class="form-control">
     </div>
     <div class="col-md-4">
      <label class="form-label">Invoice Date</label>
      <input type="date" name="invoice_date" class="form-control" required>
     </div>
    </div>
   </div>

   <!-- Vendor Info -->
   <div class="card form-section">
    <div class="card-header">Vendor Information</div>
    <div class="card-body row g-3">
     <div class="col-md-4">
      <label class="form-label">Vendor Company</label>
      <input type="text" name="vendor_company" class="form-control" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Vendor Name</label>
      <input type="text" name="vendor_name" class="form-control" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">TIN</label>
      <input type="text" name="vendor_tin" class="form-control">
     </div>
     <div class="col-md-4">
      <label class="form-label">Telephone</label>
      <input type="tel" name="vendor_phone" class="form-control">
     </div>
    </div>
   </div>

   <!-- Product Info -->
   <div class="card form-section">
    <div class="card-header">Product / Inventory Details</div>
    <div class="card-body">
     <table class="table table-bordered" id="inventory_table">
      <thead class="table-light">
       <tr>
        <th>Item Name</th>
        <th>Category</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Price</th>
        <th>Total</th>
        <th>Image</th>
        <th>Action</th>
       </tr>
      </thead>
      <tbody>
       <tr>
        <td><input type="text" name="item_name[]" class="form-control" required></td>
        <td><input type="text" name="category[]" class="form-control"></td>
        <td><input type="number" name="quantity[]" class="form-control" onchange="calculateTotal(this)"></td>
        <td><input type="text" name="unit[]" class="form-control"></td>
        <td><input type="number" name="price[]" class="form-control" onchange="calculateTotal(this)"></td>
        <td><input type="number" name="total[]" class="form-control" readonly></td>
        <td><input type="file" name="product_image[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
       </tr>
      </tbody>
     </table>
     <button type="button" class="btn btn-success" onclick="addRow()">Add Row</button>
    </div>
   </div>

   <!-- Submit -->
   <div class="text-center">
    <button type="submit" class="btn btn-primary btn-lg">Submit Inventory</button>
   </div>

  </form>
 </div>

 <script>
 function addRow() {
  const table = document.getElementById("inventory_table").getElementsByTagName('tbody')[0];
  const newRow = table.rows[0].cloneNode(true);

  newRow.querySelectorAll("input").forEach(input => {
   input.value = '';
  });

  table.appendChild(newRow);
 }

 function removeRow(btn) {
  const row = btn.closest('tr');
  const table = document.getElementById("inventory_table").getElementsByTagName('tbody')[0];
  if (table.rows.length > 1) {
   row.remove();
  }
 }

 function calculateTotal(el) {
  const row = el.closest('tr');
  const qty = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
  const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
  row.querySelector('input[name="total[]"]').value = (qty * price).toFixed(2);
 }

 function calculateTotal(el) {
  const row = el.closest('tr');
  const qty = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
  const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
  const total = qty * price;
  row.querySelector('input[name="total[]"]').value = total.toFixed(2);

  updateSummary();
 }

 function updateSummary() {
  const totals = document.querySelectorAll('input[name="total[]"]');
  let subtotal = 0;

  totals.forEach(input => {
   subtotal += parseFloat(input.value) || 0;
  });

  const vat = subtotal * 0.15;
  const grandTotal = subtotal + vat;

  document.getElementById('subtotal').value = subtotal.toFixed(2);
  document.getElementById('vat').value = vat.toFixed(2);
  document.getElementById('grand_total').value = grandTotal.toFixed(2);
 }

 function addRow() {
  const table = document.getElementById("inventory_table").getElementsByTagName('tbody')[0];
  const newRow = table.rows[0].cloneNode(true);

  newRow.querySelectorAll("input").forEach(input => {
   input.value = '';
  });

  table.appendChild(newRow);
  updateSummary();
 }
 </script>
 <div class="row mt-3">
  <div class="col-md-6 offset-md-6">
   <table class="table table-borderless">
    <tr>
     <th>Subtotal:</th>
     <td><input type="number" name="subtotal" id="subtotal" class="form-control" readonly></td>
    </tr>
    <tr>
     <th>VAT (15%):</th>
     <td><input type="number" name="vat" id="vat" class="form-control" readonly></td>
    </tr>
    <tr>
     <th>Grand Total:</th>
     <td><input type="number" name="grand_total" id="grand_total" class="form-control" readonly></td>
    </tr>
   </table>
  </div>
 </div>

</body>

</html>


kkkkk

<body>
 <div class="container my-4">
  <h1 class="text-center">ABC Company</h1>
  <h1 class="text-center">Inventory Purchase Invoice</h1>
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
   <form action="add_inventory.php" method="POST" id="purchase _form">
    <!-- Sales General Information in One Row -->
    <div class="row row-input">
     <div class="col-md-2">
      <label for="purchase _order_no" class="form-label">Purchase Order No.</label>
      <input type="text" class="form-control" id="purchase_order_no" name="purchase _order_no">
     </div>
     <div class="col-md-2">
      <label for="purchase _invoice_no" class="form-label">Purchase Invoice No.</label>
      <input type="text" class="form-control" id="purchase _invoice_no" name="purchase _invoice_no" required>
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
       <label for="vendor_id" class="form-label">vendor ID</label>
       <input type="text" class="form-control" id="vendor_id" name="vendor_id" required>
      </div>
      <div class="col-md-2">
       <label for="vendor_Company_name" class="form-label">vendor Company Name</label>
       <input type="text" class="form-control" id="vendor_company_name" name="vendor_company_name" required>
      </div>
      <div class="col-md-3">
       <label for="vendor_name" class="form-label">vendor Name</label>
       <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
      </div>
      <div class="col-md-2">
       <label for="vendor_TIN No." class="form-label">vendor TIN No</label>
       <input type="text" class="form-control" id="vendorr_TIN No" name="vendor_TIN No" required>
      </div>
      <div class="col-md-2">
       <label for="vendor_Telephone No." class="form-label">vendor Telephone No</label>
       <input type="text" class="form-control" id="vendor_Telephone No." name="vendor_Telephone No." required>
      </div>
      <div class="row row-input">
       <div class="col-md-2">
        <label for="purchase person_id" class="form-label">purchase Person ID</label>
        <input type="text" class="form-control" id="purchaseperson_id" name="purchaseperson_id" required>
       </div>

       <div class="col-md-2">
        <label for="purchaseperson_name" class="form-label">purchase Person Name</label>
        <input type="text" class="form-control" id="purchase person_name" name="purchase person_name" required>
       </div>

       kkkkkkkkkkkk

       <div class="card">
        <div class="card-body">
         <div class="row">
          <!-- Product Name -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Product Name</label>
            <input type="text" class="form-control" placeholder="Enter product name">
           </div>
          </div>

          <!-- Category -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Category</label>
            <select class="form-control select">
             <option>Choose Category</option>
             <option>Computers</option>
            </select>
           </div>
          </div>

          <!-- Sub Category -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Sub Category</label>
            <select class="form-control select">
             <option>Choose Sub Category</option>
             <option>Fruits</option>
            </select>
           </div>
          </div>

          <!-- Brand -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Brand</label>
            <select class="form-control select">
             <option>Choose Brand</option>
             <option>Brand</option>
            </select>
           </div>
          </div>

          <!-- Unit -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Unit</label>
            <select class="form-control select">
             <option>Choose Unit</option>
             <option>Unit</option>
            </select>
           </div>
          </div>

          <!-- SKU -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>SKU</label>
            <input type="text" class="form-control" placeholder="Enter SKU">
           </div>
          </div>

          <!-- Minimum Qty -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Minimum Qty</label>
            <input type="text" class="form-control" placeholder="Enter minimum quantity">
           </div>
          </div>

          <!-- Quantity -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Quantity</label>
            <input type="text" class="form-control" placeholder="Enter quantity">
           </div>
          </div>

          <!-- Description -->
          <div class="col-lg-12">
           <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Enter product description"></textarea>
           </div>
          </div>

          <!-- Tax -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Tax</label>
            <select class="form-control select">
             <option>Choose Tax</option>
             <option>2%</option>
            </select>
           </div>
          </div>

          <!-- Discount Type -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Discount Type</label>
            <select class="form-control select">
             <option>Percentage</option>
             <option>10%</option>
             <option>20%</option>
            </select>
           </div>
          </div>

          <!-- Price -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Price</label>
            <input type="text" class="form-control" placeholder="Enter price">
           </div>
          </div>

          <!-- Status -->
          <div class="col-lg-3 col-sm-6 col-12">
           <div class="form-group">
            <label>Status</label>
            <select class="form-control select">
             <option>Closed</option>
             <option>Open</option>
            </select>
           </div>
          </div>

          <!-- Product Image -->
          <div class="col-lg-12">
           <div class="form-group">
            <label>Product Image</label>
            <div class="image-upload">
             <input type="file" class="form-control">
             <div class="image-uploads">
              <img src="assets/img/icons/upload.svg" alt="Upload Icon">
              <h4>Drag and drop a file to upload</h4>
             </div>
            </div>
           </div>
          </div>


          kkkkkk

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

          document.getElementById("amount_in_words").textContent =
           `Total in Words: ${toWords(totalWithVAT)} Birr only.`;
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
         <button type="submit" class="btn btn-primary">Save purchase </button>
        </div>


</body>

</html>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">