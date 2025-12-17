kkkkkk
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_company";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape all inputs to prevent SQL injection
    $purchase_order_no = $conn->real_escape_string($_POST['purchase_order_no']);
    $purchase_invoice_no = $conn->real_escape_string($_POST['purchase_invoice_no']);
    $reference = $conn->real_escape_string($_POST['reference']);
    $invoice_date = $conn->real_escape_string($_POST['invoice_date']);
    $vendor_id = $conn->real_escape_string($_POST['vendor_id']);
    $vendor_company_name = $conn->real_escape_string($_POST['vendor_company_name']);
    $vendor_name = $conn->real_escape_string($_POST['vendor_name']);
    $vendor_tin_no = $conn->real_escape_string($_POST['vendor_tin_no']);
    $vendor_telephone = $conn->real_escape_string($_POST['vendor_phone']);
    $purchase_person_id = $conn->real_escape_string($_POST['purchase_person_id']);
    $purchase_person_name = $conn->real_escape_string($_POST['purchase_person_name']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    $product_name = $conn->real_escape_string($_POST['product_name']);
    $category = $conn->real_escape_string($_POST['category']);
    $sub_category = $conn->real_escape_string($_POST['sub_category']);
    $brand = $conn->real_escape_string($_POST['brand']);
    $unit = $conn->real_escape_string($_POST['unit']);
    $sku = $conn->real_escape_string($_POST['sku']);
    $min_qty = (int)$_POST['min_qty'];
    $quantity = (int)$_POST['quantity'];
    $description = $conn->real_escape_string($_POST['description']);

    // File Upload
    $image_url = "";
    if (!empty($_FILES['purchase_image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = basename($_FILES["purchase_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["purchase_image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        } else {
            $error_message = "Error uploading file.";
        }
    }

    // Insert into inventory
    if (empty($error_message)) {
        $stmt = $conn->prepare("INSERT INTO inventory (
            purchase_or_no, purchase_invoice_no, reference, invoice_date,
            vendor_id, vendor_company_name, vendor_name, vendor_tin_no, vendor_telephone,
            purchase_person_id, purchase_person_name, payment_method, image_url,
            product_name, category, sub_category, brand, unit, sku, min_qty, quantity, description
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssssssssssssssis",
            $purchase_order_no,
            $purchase_invoice_no,
            $reference,
            $invoice_date,
            $vendor_id,
            $vendor_company_name,
            $vendor_name,
            $vendor_tin_no,
            $vendor_telephone,
            $purchase_person_id,
            $purchase_person_name,
            $payment_method,
            $image_url,
            $product_name,
            $category,
            $sub_category,
            $brand,
            $unit,
            $sku,
            $min_qty,
            $quantity,
            $description
        );

        if ($stmt->execute()) {
            $success_message = "Inventory data saved successfully!";
        } else {
            $error_message = "Error saving data: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_company"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $purchase_order_no = $_POST['purchase_order_no'];
    $purchase_invoice_no = $_POST['purchase_invoice_no'];
    $reference = $_POST['reference'];
    $invoice_date = $_POST['invoiceDate'];
    $vendor_id = $_POST['vendor_id'];
    $vendor_company_name = $_POST['vendor_company_name'];
    $vendor_name = $_POST['vendor_name'];
    $vendor_tin_no = $_POST['vendor_TIN_No'];
    $vendor_telephone = $_POST['vendor_telephone'];
    $purchase_person_id = $_POST['purchase_person_id'];
    $purchase_person_name = $_POST['purchase_person_name'];
    $payment_method = $_POST['payment_method'];

    // Handle file upload for image (if provided)
    $image_url = "";
    if (isset($_FILES['purchase_image']) && $_FILES['purchase_image']['error'] == 0) {
        $target_dir = "uploads/"; // Ensure the 'uploads' folder exists
        $image_url = $target_dir . basename($_FILES["purchase_image"]["name"]);
        move_uploaded_file($_FILES["purchase_image"]["tmp_name"], $image_url);
    }

    // Insert form data into the inventory table
    $sql = "INSERT INTO inventory (purchase_order_no, purchase_invoice_no, reference, invoice_date, vendor_id, vendor_company_name, vendor_name, vendor_tin_no, vendor_telephone, purchase_person_id, purchase_person_name, payment_method, image_url)
            VALUES ('$purchase_order_no', '$purchase_invoice_no', '$reference', '$invoice_date', '$vendor_id', '$vendor_company_name', '$vendor_name', '$vendor_tin_no', '$vendor_telephone', '$purchase_person_id', '$purchase_person_name', '$payment_method', '$image_url')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Inventory data saved successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory Purchase Invoice</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
 <div class="container my-4">
  <h1 class="text-center">ABC Company</h1>
  <h2 class="text-center">Inventory Purchase Invoice</h2>
  <h6 class="text-center">
   <address>Bole, XXXXXXX | Telephone: XXX | Email: info@abccompany.com</address>
  </h6>

  <!-- Display success or error message -->
  <?php if (isset($success_message)): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
  <?php elseif (isset($error_message)): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
  <?php endif; ?>

  <!-- Purchase Form -->
  <div class="card p-4">
   <form action="add_inventory.php" method="POST" id="purchase_form">
    <!-- Purchase Order Information -->
    <div class="row mb-3">
     <div class="col-md-2">
      <label for="purchase_order_no" class="form-label">Order No.</label>
      <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no">
     </div>
     <div class="col-md-2">
      <label for="purchase_invoice_no" class="form-label">Invoice No.</label>
      <input type="text" class="form-control" id="purchase_invoice_no" name="purchase_invoice_no" required>
     </div>
     <div class="col-md-2">
      <label for="reference" class="form-label">Reference</label>
      <input type="text" class="form-control" id="reference" name="reference" required>
     </div>
     <div class="col-md-2">
      <label for="invoice_date" class="form-label">Invoice Date</label>
      <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
     </div>
    </div>

    <!-- Vendor Information -->
    <div class="row mb-3">
     <div class="col-md-2">
      <label for="vendor_id" class="form-label">Vendor ID</label>
      <input type="text" class="form-control" id="vendor_id" name="vendor_id" required>
     </div>
     <div class="col-md-3">
      <label for="vendor_company_name" class="form-label">Company Name</label>
      <input type="text" class="form-control" id="vendor_company_name" name="vendor_company_name" required>
     </div>
     <div class="col-md-3">
      <label for="vendor_name" class="form-label">Vendor Name</label>
      <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
     </div>
     <div class="col-md-2">
      <label for="vendor_tin_no" class="form-label">TIN No</label>
      <input type="text" class="form-control" id="vendor_tin_no" name="vendor_tin_no" required>
     </div>
     <div class="col-md-2">
      <label for="vendor_phone" class="form-label">Telephone</label>
      <input type="text" class="form-control" id="vendor_phone" name="vendor_phone" required>
     </div>
    </div>

    <!-- Purchase Person Info -->
    <div class="row mb-4">
     <div class="col-md-3">
      <label for="purchase_person_id" class="form-label">Purchase Person ID</label>
      <input type="text" class="form-control" id="purchase_person_id" name="purchase_person_id" required>
     </div>
     <div class="col-md-3">
      <label for="purchase_person_name" class="form-label">Purchase Person Name</label>
      <input type="text" class="form-control" id="purchase_person_name" name="purchase_person_name" required>
     </div>
    </div>

    <!-- Product Details Card -->
    <div class="card mb-4">
     <div class="card-header">Product Details</div>
     <div class="card-body row g-3">
      <div class="col-lg-3 col-6">
       <label class="form-label">Product Name</label>
       <input type="text" class="form-control" name="product_name" placeholder="Enter product name">
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Category</label>
       <select class="form-control" name="category">
        <option value="">Choose Category</option>
        <option value="Computers">Computers</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Sub Category</label>
       <select class="form-control" name="sub_category">
        <option value="">Choose Sub Category</option>
        <option value="Fruits">Fruits</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Brand</label>
       <select class="form-control" name="brand">
        <option value="">Choose Brand</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Unit</label>
       <select class="form-control" name="unit">
        <option value="">Choose Unit</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">SKU</label>
       <input type="text" class="form-control" name="sku" placeholder="Enter SKU">
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Minimum Qty</label>
       <input type="number" class="form-control" name="min_qty" placeholder="Min Qty">
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Quantity</label>
       <input type="number" class="form-control" name="quantity" placeholder="Quantity">
      </div>
      <div class="col-12">
       <label class="form-label">Description</label>
       <textarea class="form-control" name="description" rows="2" placeholder="Enter description"></textarea>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Tax</label>
       <select class="form-control" name="tax">
        <option>Choose Tax</option>
        <option value="2%">2%</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Discount Type</label>
       <select class="form-control" name="discount_type">
        <option value="0">None</option>
        <option value="10%">10%</option>
        <option value="20%">20%</option>
       </select>
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Price</label>
       <input type="text" class="form-control" name="price" placeholder="Enter price">
      </div>
      <div class="col-lg-3 col-6">
       <label class="form-label">Status</label>
       <select class="form-control" name="status">
        <option value="closed">Closed</option>
        <option value="open">Open</option>
       </select>
      </div>
      <div class="col-12">
       <label class="form-label">Product Image</label>
       <input type="file" class="form-control" name="product_image">
      </div>
     </div>
    </div>

    <!-- Payment Method -->
    <div class="row mb-3">
     <div class="col-md-3">
      <label for="payment_method" class="form-label">Payment Method</label>
      <select class="form-control" id="payment_method" name="payment_method" required>
       <option value="">Select Payment Method</option>
       <option value="cash">Cash</option>
       <option value="cheque">Cheque</option>
       <option value="bank">Bank Transfer</option>
       <option value="other">Other</option>
      </select>
     </div>
    </div>

    <!-- Submit Button -->
    <div class="text-end">
     <button type="submit" class="btn btn-primary">Submit Purchase</button>
    </div>
   </form>
  </div>
 </div>
</body>
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

 <div class="text-center mt-4">
  <button type="submit" class="btn btn-primary">Save purchase </button>
 </div>


</body>

</html>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

inventory add_inventory


kkkkk
<?php
require_once 'db.php';

$success_message = '';
$error_message = '';

try {
    $conn->begin_transaction();

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . uniqid() . "_" . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $conn->real_escape_string($targetPath);
        } else {
            throw new Exception("Image upload failed.");
        }
    }

    $item_stmt = $conn->prepare("INSERT INTO inventory (
        item_id, item_description, gl_account, 
        quantity, unit_price, job_id
    ) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$item_stmt) {
        throw new Exception("Item insert prepare failed: " . $conn->error);
    }

    foreach ($_POST['item_id'] as $i => $item_id) {
        $item_id = $conn->real_escape_string($_POST['item_id'][$i]);
        $item_description = $conn->real_escape_string($_POST['item_description'][$i]);
        $gl_account = $conn->real_escape_string($_POST['gl_account'][$i]);
        $quantity = (float) $_POST['quantity'][$i];
        $unit_price = (float) $_POST['unit_price'][$i];
        $job_id = isset($_POST['job_id'][$i]) ? $conn->real_escape_string($_POST['job_id'][$i]) : '';

        $item_stmt->bind_param(
            "sssdds",
            $item_id,
            $item_description,
            $gl_account,
            $quantity,
            $unit_price,
            $job_id
        );

        if (!$item_stmt->execute()) {
            throw new Exception("Item insert failed: " . $item_stmt->error);
        }
    }

    $item_stmt->close();
    $conn->commit();

    $success_message = "Inventory data successfully saved.";
} catch (Exception $e) {
    $conn->rollback();
    $error_message = "Transaction failed: " . $e->getMessage();
}

$conn->close();
?>


<!-- Rest of your form -->
</div>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory Management System</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
 .gradient-header {
  background: linear-gradient(120deg, #6c5ce7, #a8a4e6);
  color: white;
  border-radius: 15px;
 }

 .shadow-card {
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
 }
 </style>
</head>

<body>
 <div class="container py-4">
  <div class="gradient-header p-4 mb-4">
   <h1 class="text-center display-4 fw-bold">ABC Company</h1>
   <h2 class="text-center h3">Inventory Purchase Invoice</h2>
   <p class="text-center mb-0">
    Bole, Addis Ababa | Tel: +251 912 345 678 | Email: info@abccompany.et
   </p>
  </div>

  <?php if ($success_message): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
   <?= htmlspecialchars($success_message) ?>
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php elseif ($error_message): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <?= htmlspecialchars($error_message) ?>
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card shadow-card border-0">
   <div class="card-body p-4">
    <!-- Main Form Sections -->
    <div class="row g-3 mb-4">
     <div class="col-md-3">
      <label class="form-label">Order No.</label>
      <input type="text" class="form-control" name="purchase_order_no" required>
     </div>
     <div class="col-md-3">
      <label class="form-label">Invoice No.</label>
      <input type="text" class="form-control" name="purchase_invoice_no" required>
     </div>
     <div class="col-md-3">
      <label class="form-label">Reference</label>
      <input type="text" class="form-control" name="reference" required>
     </div>
     <div class="col-md-3">
      <label class="form-label">Invoice Date</label>
      <input type="date" class="form-control" name="invoice_date" required>
     </div>
    </div>

    <!-- Vendor Information -->
    <div class="row g-3 mb-4">
     <div class="col-md-4">
      <label class="form-label">Vendor ID</label>
      <input type="text" class="form-control" name="vendor_id" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Company Name</label>
      <input type="text" class="form-control" name="vendor_company_name" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Vendor Name</label>
      <input type="text" class="form-control" name="vendor_name" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">TIN No</label>
      <input type="text" class="form-control" name="vendor_tin_no" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Telephone</label>
      <input type="text" class="form-control" name="vendor_phone" required>
     </div>
    </div>

    <!-- Item Details Table -->
    <div class="mb-4">
     <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>Item Details</h5>
      <button type="button" class="btn btn-primary" onclick="addRow()">Add Item</button>
     </div>
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
       <!-- Rows added dynamically -->
      </tbody>
     </table>
    </div>

    <!-- Summary Section -->
    <div class="mb-4 p-3 bg-light rounded">
     <div class="row">
      <div class="col-md-4">
       <p class="mb-1">Total Before VAT: <span id="total_sales_before_vat">0.00</span></p>
       <p class="mb-1">VAT (15%): <span id="vat_amount">0.00</span></p>
       <p class="mb-1">Total with VAT: <span id="sales_with_vat">0.00</span></p>
      </div>
      <div class="col-md-8">
       <p id="amount_in_words" class="mb-0 fw-bold"></p>
      </div>
     </div>
    </div>

    <!-- File Upload and Submit -->
    <div class="row g-3 mb-4">
     <div class="col-md-6">
      <label class="form-label">Payment Method</label>
      <select class="form-select" name="payment_method" required>
       <option value="">Select Payment Method</option>
       <option value="Cash">Cash</option>
       <option value="Cheque">Cheque</option>
       <option value="Bank Transfer">Bank Transfer</option>
      </select>
     </div>
     <div class="col-md-6">
      <label class="form-label">Upload Image</label>
      <input type="file" class="form-control" name="purchase_image" accept="image/*">
     </div>
    </div>

    <div class="text-end">
     <button type="submit" class="btn btn-primary btn-lg px-4">Save Inventory</button>
    </div>
   </div>
  </form>
 </div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 <script>
 // JavaScript functions for dynamic table
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
            <td><input type="number" class="form-control" name="quantity[]" step="0.01" min="0" oninput="calculateTotal(this)" required></td>
            <td><input type="number" class="form-control" name="unit_price[]" step="0.01" min="0" oninput="calculateTotal(this)" required></td>
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
  // Number to words conversion logic
  // ... (keep the existing toWords implementation) ...
 }
 </script>
</body>

</html>