<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory Management</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
 $(document).ready(function() {
  function calculateTotal(row) {
   let quantity = parseFloat(row.find('.quantity').val()) || 0;
   let price = parseFloat(row.find('.price').val()) || 0;
   row.find('.total').val((quantity * price).toFixed(2));
   updateSummary();
  }

  function updateSummary() {
   let subtotal = 0;
   $('.total').each(function() {
    subtotal += parseFloat($(this).val()) || 0;
   });
   let vat = subtotal * 0.15;
   let grandTotal = subtotal + vat;
   $('#subtotal').val(subtotal.toFixed(2));
   $('#vat').val(vat.toFixed(2));
   $('#grand_total').val(grandTotal.toFixed(2));
   $('#amount_in_words').text(`Total in Words: ${toWords(grandTotal)} Birr only.`);
  }

  function toWords(amount) {
   const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven",
    "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
   ];
   const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
   const scales = ["", "Thousand", "Million", "Billion"];

   function convertToWords(num) {
    if (num < 20) return ones[num];
    if (num < 100) return tens[Math.floor(num / 10)] + (num % 10 ? " " + ones[num % 10] : "");
    if (num < 1000) return ones[Math.floor(num / 100)] + " Hundred" + (num % 100 ? " " + convertToWords(num % 100) :
     "");
    for (let i = 0; i < scales.length; i++) {
     let unit = Math.pow(1000, i + 1);
     if (num < unit) return convertToWords(Math.floor(num / Math.pow(1000, i))) + " " + scales[i] + (num % Math.pow(
      1000, i) ? " " + convertToWords(num % Math.pow(1000, i)) : "");
    }
    return "";
   }
   return convertToWords(Math.floor(amount));
  }

  $(document).on('input', '.quantity, .price', function() {
   calculateTotal($(this).closest('tr'));
  });

  $('#addRow').click(function() {
   let newRow = $('#itemTable tbody tr:first').clone();
   newRow.find('input').val('');
   $('#itemTable tbody').append(newRow);
  });

  $(document).on('click', '.removeRow', function() {
   if ($('#itemTable tbody tr').length > 1) {
    $(this).closest('tr').remove();
    updateSummary();
   }
  });
 });
 </script>
</head>

<body>
 <div class="container mt-5">
  <h3 class="text-center mb-4">Purchase Form</h3>
  <div class="card p-4">
   <form action="add_inventory.php" method="POST" id="purchase_form">
    <div class="row">
     <div class="col-md-3">
      <label for="purchase_order_no" class="form-label">Purchase Order No.</label>
      <input type="text" class="form-control" name="purchase_order_no">
     </div>
     <div class="col-md-3">
      <label for="vendor_name" class="form-label">Vendor Name</label>
      <input type="text" class="form-control" name="vendor_name" required>
     </div>
     <div class="col-md-3">
      <label for="invoiceDate" class="form-label">Invoice Date</label>
      <input type="date" class="form-control" name="invoice_date" required>
     </div>
    </div>

    <table id="itemTable" class="table table-bordered mt-3">
     <thead>
      <tr>
       <th>Item ID</th>
       <th>Description</th>
       <th>Quantity</th>
       <th>Unit Price</th>
       <th>Total Cost</th>
       <th>Action</th>
      </tr>
     </thead>
     <tbody>
      <tr>
       <td><input type="text" class="form-control" name="item_id[]" required></td>
       <td><input type="text" class="form-control" name="item_description[]" required></td>
       <td><input type="number" class="form-control quantity" name="quantity[]" required></td>
       <td><input type="number" class="form-control price" name="unit_price[]" required></td>
       <td><input type="number" class="form-control total" name="total_cost[]" readonly></td>
       <td><button type="button" class="removeRow btn btn-danger">Remove</button></td>
      </tr>
     </tbody>
    </table>

    <button type="button" id="addRow" class="btn btn-primary">Add Row</button>

    <div class="mt-4">
     <div class="row">
      <div class="col-md-6">Subtotal:</div>
      <div class="col-md-6"><input type="text" id="subtotal" class="form-control" readonly></div>
     </div>
     <div class="row">
      <div class="col-md-6">VAT (15%):</div>
      <div class="col-md-6"><input type="text" id="vat" class="form-control" readonly></div>
     </div>
     <div class="row">
      <div class="col-md-6">Grand Total:</div>
      <div class="col-md-6"><input type="text" id="grand_total" class="form-control" readonly></div>
     </div>
     <div class="row">
      <div class="col-md-12">
       <p id="amount_in_words" class="fw-bold"></p>
      </div>
     </div>
    </div>
    <button type="submit" class="btn btn-success mt-3">Submit</button>
   </form>
  </div>
 </div>
</body>

</html>

kkkkk
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory Management</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
 $(document).ready(function() {
  function calculateTotal(row) {
   let quantity = parseFloat(row.find('.quantity').val()) || 0;
   let price = parseFloat(row.find('.price').val()) || 0;
   row.find('.total').val((quantity * price).toFixed(2));
   updateSummary();
  }

  function updateSummary() {
   let subtotal = 0;
   $('.total').each(function() {
    subtotal += parseFloat($(this).val()) || 0;
   });
   let vat = subtotal * 0.15;
   let grandTotal = subtotal + vat;
   $('#subtotal').val(subtotal.toFixed(2));
   $('#vat').val(vat.toFixed(2));
   $('#grand_total').val(grandTotal.toFixed(2));
   $('#amount_in_words').text(`Total in Words: ${toWords(grandTotal)} Birr only.`);
  }

  function toWords(amount) {
   const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten"];
   const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
   const scales = ["", "Thousand", "Million"];
   if (amount === 0) return "Zero";
   let words = [];
   let numStr = Math.floor(amount).toString().match(/.{1,3}(?=(.{3})*$)/g).reverse();
   numStr.forEach((part, index) => {
    if (parseInt(part) === 0) return;
    let str = '';
    let hundreds = Math.floor(part / 100);
    let remainder = part % 100;
    if (hundreds > 0) str += ones[hundreds] + " Hundred ";
    if (remainder < 20) str += ones[remainder];
    else str += tens[Math.floor(remainder / 10)] + " " + ones[remainder % 10];
    words.push(str + (scales[index] ? " " + scales[index] : ""));
   });
   return words.reverse().join(" ").trim();
  }

  $(document).on('input', '.quantity, .price', function() {
   calculateTotal($(this).closest('tr'));
  });

  $('#addRow').click(function() {
   let newRow = $('#itemTable tbody tr:first').clone();
   newRow.find('input').val('');
   $('#itemTable tbody').append(newRow);
  });

  $(document).on('click', '.removeRow', function() {
   if ($('#itemTable tbody tr').length > 1) {
    $(this).closest('tr').remove();
    updateSummary();
   }
  });

  $('#submitForm').click(function() {
   $('form').submit();
  });
 });
 </script>
</head>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventory Management</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
 $(document).ready(function() {
  function calculateTotal(row) {
   let quantity = parseFloat(row.find('.quantity').val()) || 0;
   let price = parseFloat(row.find('.price').val()) || 0;
   row.find('.total').val((quantity * price).toFixed(2));
   updateSummary();
  }

  function updateSummary() {
   let subtotal = 0;
   $('.total').each(function() {
    subtotal += parseFloat($(this).val()) || 0;
   });
   let vat = subtotal * 0.15;
   let grandTotal = subtotal + vat;
   $('#subtotal').val(subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
   $('#vat').val(vat.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
   $('#grand_total').val(grandTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
   $('#amount_in_words').text(`Total in Words: ${toWords(grandTotal)} Birr only.`);
  }

  function toWords(amount) {
   const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten"];
   const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
   const scales = ["", "Thousand", "Million"];
   if (amount === 0) return "Zero";
   let words = [];
   let numStr = Math.floor(amount).toString().match(/.{1,3}(?=(.{3})*$)/g).reverse();
   numStr.forEach((part, index) => {
    if (parseInt(part) === 0) return;
    let str = '';
    let hundreds = Math.floor(part / 100);
    let remainder = part % 100;
    if (hundreds > 0) str += ones[hundreds] + " Hundred ";
    if (remainder < 20) str += ones[remainder];
    else str += tens[Math.floor(remainder / 10)] + " " + ones[remainder % 10];
    words.push(str + (scales[index] ? " " + scales[index] : ""));
   });
   return words.reverse().join(" ").trim();
  }

  $(document).on('input', '.quantity, .price', function() {
   calculateTotal($(this).closest('tr'));
  });

  $('#addRow').click(function() {
   let newRow = $('#itemTable tbody tr:first').clone();
   newRow.find('input').val('');
   $('#itemTable tbody').append(newRow);
  });

  $(document).on('click', '.removeRow', function() {
   if ($('#itemTable tbody tr').length > 1) {
    $(this).closest('tr').remove();
    updateSummary();
   }
  });

  $('#submitForm').click(function() {
   $('form').submit();
  });
 });
 </script>
</head>

<body>
 <div class="container mt-5">
  <h3 class="text-center mb-4">Purchase Form</h3>
  <div class="card p-4">
   <form action="add_inventory.php" method="POST" id="purchase_form">
    <div class="row">
     <div class="col-md-3">
      <label for="purchase_order_no" class="form-label">Purchase Order No.</label>
      <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no">
     </div>
     <div class="col-md-3">
      <label for="purchase_invoice_no" class="form-label">Invoice No.</label>
      <input type="text" class="form-control" id="purchase_invoice_no" name="purchase_invoice_no" required>
     </div>
     <div class="col-md-3">
      <label for="Reference" class="form-label">Reference No.</label>
      <input type="text" class="form-control" id="reference" name="reference" required>
     </div>
     <div class="col-md-3">
      <label for="vendor_name" class="form-label">Vendor Name</label>
      <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
     </div>
     <div class="col-md-3">
      <label for="tin_no" class="form-label">Tin No</label>
      <input type="text" class="form-control" id="tin_no" name="tin_no" required>
     </div>

     <div class="col-md-3">
      <label for="invoiceDate" class="form-label">Invoice Date:</label>
      <input type="date" class="form-control" id="invoiceDate" required>
     </div>
    </div>

    <div class="row mt-3">
     <div class="col-md-3">
      <label for="vendor_telephone" class="form-label">Vendor Phone</label>
      <input type="text" class="form-control" id="vendor_telephone" name="vendor_telephone" required>
     </div>
     <div class="col-md-3">
      <label for="purchaseperson_name" class="form-label">Purchaser Name</label>
      <input type="text" class="form-control" id="purchaseperson_name" name="purchaseperson_name" required>
     </div>
     <div class="col-md-3">
      <label for="payment_method" class="form-label">Payment Method</label>
      <select class="form-select" id="payment_method" name="payment_method" required>
       <option value="">Select Method</option>
       <option value="Cash">Cash</option>
       <option value="Credit">Credit</option>
      </select>
     </div>
    </div>

    <table id="itemTable" class="table table-bordered mt-3">
     <thead>
      <tr>
       <th>Item ID</th>
       <th>Description</th>
       <th>GL Account</th>
       <th>Quantity</th>
       <th>Unit Price</th>
       <th>Total Cost</th>
       <th>Action</th>
      </tr>
     </thead>
     <tbody>
      <tr>
       <td><input type="text" class="form-control" name="item_id[]" required></td>
       <td><input type="text" class="form-control" name="item_description[]" required></td>
       <td><input type="text" class="form-control" name="gl_account[]" required></td>
       <td><input type="number" class="form-control quantity" name="quantity[]" step="1" min="1" required></td>
       <td><input type="number" class="form-control price" name="unit_price[]" step="0.01" min="0.01" required></td>
       <td><input type="number" class="form-control total" name="total_cost[]" readonly></td>
       <td><button type="button" class="removeRow btn btn-danger">Remove</button></td>
      </tr>
     </tbody>
    </table>

    <button type="button" id="addRow" class="btn btn-primary">Add Row</button>

    <div class="d-flex justify-content-between mt-4">
     <div class="col-md-6">
      <h4>Summary</h4>
      <div class="row">
       <div class="col-md-6">Subtotal:</div>
       <div class="col-md-6"><input type="text" id="subtotal" class="form-control" readonly></div>
      </div>
      <div class="row">
       <div class="col-md-6">VAT (15%):</div>
       <div class="col-md-6"><input type="text" id="vat" class="form-control" readonly></div>
      </div>
      <div class="row">
       <div class="col-md-6">Grand Total:</div>
       <div class="col-md-6"><input type="text" id="grand_total" class="form-control" readonly></div>
      </div>
      <p id="amount_in_words"></p>
     </div>
    </div>

    <!-- Three signatory lines -->
    <div class="row mt-4">
     <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Signatory 1" name="signatory1">
      <div class="signature-line"></div>
     </div>
     <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Signatory 2" name="signatory2">
      <div class="signature-line"></div>
     </div>
     <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Signatory 3" name="signatory3">
      <div class="signature-line"></div>
     </div>
    </div>

    <div class="text-center mt-4">
     <button type="submit" id="submitForm" class="btn btn-success">Submit</button>
    </div>
   </form>
  </div>
 </div>
</body>

</html>

<style>
body {
 font-family: 'Arial', sans-serif;
 background-color: #f8f9fa;
}

.container {
 max-width: 800px;
 margin: auto;
}

.card {
 border-radius: 8px;
 padding: 30px;
 background-color: #fff;
}

h3,
h4 {
 font-weight: bold;
}

.signature-line {
 border-top: 1px solid #000;
 margin-top: -5px;
}

.d-flex {
 display: flex;
}

.signature-field input {
 width: 100%;
}

.row input[type="text"] {
 width: 100%;
}

.row .signature-line {
 margin-top: 5px;
 height: 2px;
 background-color: #000;
}
</style>


fffffffffffff
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