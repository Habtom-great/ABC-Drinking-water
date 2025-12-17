<?php
session_start();
include 'header.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ABC_Company";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$items = fetchInventoryItems($conn);

// Fetch inventory items
function fetchInventoryItems($conn)
{
    return $conn->query("SELECT item_id, item_description, unit_price FROM inventory");
}

// Convert numbers to words
function numberToWords($num)
{
    $ones = [
        '',
        'One',
        'Two',
        'Three',
        'Four',
        'Five',
        'Six',
        'Seven',
        'Eight',
        'Nine',
        'Ten',
        'Eleven',
        'Twelve',
        'Thirteen',
        'Fourteen',
        'Fifteen',
        'Sixteen',
        'Seventeen',
        'Eighteen',
        'Nineteen'
    ];
    $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    $thousands = ['', 'Thousand', 'Million', 'Billion'];

    if ($num == 0) return 'Zero';

    $numArr = array_reverse(str_split(strval($num), 3));
    $result = [];

    foreach ($numArr as $i => $chunk) {
        $chunk = (int) $chunk;
        if ($chunk == 0) continue;

        $str = '';
        if ($chunk >= 100) {
            $str .= $ones[intval($chunk / 100)] . ' Hundred ';
            $chunk %= 100;
        }
        if ($chunk >= 20) {
            $str .= $tens[intval($chunk / 10)] . ' ';
            $chunk %= 10;
        }
        if ($chunk > 0) {
            $str .= $ones[$chunk] . ' ';
        }

        $result[] = $str . $thousands[$i];
    }

    return implode(' ', array_reverse($result)) . ' Birr only';
}

// Handle invoice creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    processInvoice($conn, $_POST);
}

// Process invoice
function processInvoice($conn, $data)
{
    $invoice_no = $data['invoice_no'];
    $reference = $data['reference'];
    $GL_account = $data['GL_account'];
    $items_data = $data['items'];
    $grand_total = $data['grand_total_after_vat'];
    $date = $data['created_at'];

    $sql = "INSERT INTO invoices (invoice_no, reference, GL_account, total_amount, created_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $invoice_no, $reference, $GL_account, $grand_total, $date);

    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id;
        insertInvoiceItems($conn, $invoice_id, $GL_account, $items_data);
        header("Location: invoice.php?success=1");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Insert invoice items
function insertInvoiceItems($conn, $invoice_id, $GL_account, $items_data)
{
    $sql = "INSERT INTO invoice_items (invoice_id, item_id, quantity, GL_account, unit_price, total_price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    foreach ($items_data as $item) {
        $stmt->bind_param("iiisdd", $invoice_id, $item['item_id'], $item['quantity'], $GL_account, $item['unit_price'], $item['total_price']);
        $stmt->execute();
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin-top: 100px;
        }

        .form-control,
        .form-select {
            height: 35px;
            font-size: 14px;
        }

        .table th,
        .table td {
            padding: 8px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h4 class="text-center mb-3">Create Invoice</h4>
        <form id="invoiceForm">
            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label">Invoice No:</label>
                    <input type="text" class="form-control" name="invoice_no" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date:</label>
                    <input type="date" class="form-control" name="created_at" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Reference:</label>
                    <input type="text" class="form-control" name="reference">
                </div>
                <div class="col-md-3">
                    <label class="form-label">GL Account:</label>
                    <input type="text" class="form-control" name="GL_account">
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="items-container"></tbody>
            </table>
            <button type="button" class="btn btn-primary btn-sm" onclick="addItemRow()">Add Item</button>

            <div class="text-end mt-3">
                <h4>Grand Total Before VAT: Birr <span id="grand-total-before-vat"> 0.00</span></h4>
                <h4>VAT (15%): Birr <span id="vat-total"> 0.00</span></h4>
                <h4>Grand Total After VAT: Birr <span id="grand-total-after-vat"> 0.00</span></h4>
                <h4>Amount in Words: <span id="amount-in-words">Zero</span></h4>
                <input type="hidden" name="grand_total_after_vat" id="grand-total-after-vat-input">
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Create Invoice</button>
            </div>
        </form>
    </div>

    <script>
        function addItemRow() {
            let row = `<tr>
                            <td><input type="text" class="form-control item-desc" name="items[][description]" required></td>
                            <td><input type="text" class="form-control price" name="items[][unit_price]" required></td>
                            <td><input type="number" class="form-control qty" name="items[][quantity]" required></td>
                            <td><input type="text" class="form-control total" name="items[][total_price]" readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>
                        </tr>`;
            $('#items-container').append(row);
            attachRowEvents();
        }

        function removeRow(button) {
            $(button).closest('tr').remove();
            calculateTotal();
        }

        function attachRowEvents() {
            $('.qty, .price').on('input', function() {
                let row = $(this).closest('tr');
                let price = parseFloat(row.find('.price').val()) || 0;
                let qty = parseInt(row.find('.qty').val()) || 0;
                let total = price * qty;
                row.find('.total').val(total.toLocaleString());
                calculateTotal();
            });
        }

        function calculateTotal() {
            let total = 0;
            $('.total').each(function() {
                total += parseFloat($(this).val().replace(/,/g, '')) || 0;
            });
            $('#grand-total-before-vat').text(total.toLocaleString());
            let vat = total * 0.15;
            $('#vat-total').text(vat.toLocaleString());
            let grandTotal = total + vat;
            $('#grand-total-after-vat').text(grandTotal.toLocaleString());
            $('#grand-total-after-vat-input').val(grandTotal);

            let amountInWords = convertToWords(grandTotal);
            $('#amount-in-words').text(amountInWords);
        }

        function convertToWords(amount) {
            let parts = amount.toString().split(".");
            let wholePart = parseInt(parts[0]);
            let words = numberToWords(wholePart);
            return words;
        }

        $('#invoiceForm').on('submit', function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            $.post('invoice.php', formData, function(response) {
                alert('Invoice Created Successfully!');
            });
        });

        // Initialize first item row
        addItemRow();

        function numberToWords(num) {
            const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
                'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
            ];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            const thousands = ['', 'Thousand', 'Million', 'Billion'];

            if (num === 0) return 'Zero';

            let numStr = num.toString().split('.');
            let wholeNumber = parseInt(numStr[0]); // Whole number part
            let result = [];

            // Process whole number part
            if (wholeNumber > 0) {
                let chunkIndex = 0;
                while (wholeNumber > 0) {
                    let chunk = wholeNumber % 1000;
                    if (chunk > 0) {
                        let chunkStr = processChunk(chunk, ones, tens);
                        result.unshift(chunkStr + (thousands[chunkIndex] ? ' ' + thousands[chunkIndex] : ''));
                    }
                    wholeNumber = Math.floor(wholeNumber / 1000);
                    chunkIndex++;
                }
            }

            // Combine and return
            return result.join(' ') + ' Birr only';
        }
        document.getElementById('items').addEventListener('change', function() {
            const selectedId = this.value;
            const selectedItem = itemsData.find(item => item.id == selectedId);

            if (selectedItem) {
                // Display price and amount in words
                const price = selectedItem.price;
                document.getElementById('price-display').textContent = `Price: ${price.toLocaleString()} Birr`;

                // Convert price to words
                const priceInWords = numberToWords(price);
                document.getElementById('amount-in-words').textContent = `Amount in Words: ${priceInWords}`;
            } else {
                document.getElementById('price-display').textContent = '';
                document.getElementById('amount-in-words').textContent = '';
            }
        });

        function processChunk(chunk, ones, tens) {
            let str = '';

            if (chunk >= 100) {
                str += ones[Math.floor(chunk / 100)] + ' Hundred ';
                chunk %= 100;
            }
            if (chunk >= 20) {
                str += tens[Math.floor(chunk / 10)] + ' ';
                chunk %= 10;
            }
            if (chunk > 0) {
                str += ones[chunk] + ' ';
            }

            return str.trim();
        }
    </script>
</body>

</html>

kkkkkkkkkkkkkkkkkk

<?php

include 'header.php';

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

$items = $conn->query("SELECT item_id, item_description, unit_price FROM inventory");

// Function to convert numbers to words

// Handle invoice creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_no = $_POST['invoice_no'];
    $reference = $_POST['reference'];
    $GL_account = $_POST['GL_account'];
    $items_data = $_POST['items'];
    $grand_total = $_POST['grand_total_after_vat'];
    $date = $_POST['date'];

    $sql = "INSERT INTO invoices (invoice_no, reference, GL_account, total_amount, created_at) 
            VALUES ('$invoice_no', '$reference', '$GL_account', '$grand_total', '$date')";

    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;

        foreach ($items_data as $item) {
            $item_id = $item['item_id'];
            $quantity = $item['quantity'];
            $unit_price = $item['unit_price'];
            $total_price = $item['total_price'];

            $sql = "INSERT INTO invoice_items (invoice_id, item_id, quantity, GL_account, unit_price, total_price) 
                    VALUES ('$invoice_id', '$item_id', '$quantity', '$GL_account', '$unit_price', '$total_price')";
            $conn->query($sql);
        }
        header("Location: invoice.php?success=1");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
$conn->close();
?>

<div class="container mt-4">
    <h2 class="mb-3 text-center">Create Invoice</h2>

    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
        <div class="row mb-2">
            <div class="col-md-3">
                <label>Invoice No.</label>
                <input type="text" name="invoice_no" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Reference</label>
                <input type="text" name="reference" class="form-control">
            </div>
            <div class="col-md-3">
                <label>GL Account</label>
                <input type="text" name="GL_account" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Date</label>
                <input type="text" name="date" class="form-control datepicker" required>
            </div>
        </div>

        <table class="table table-sm table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="items-container"></tbody>
        </table>

        <button type="button" class="btn btn-secondary btn-sm" onclick="addItemRow()">Add Item</button>

        <div class="text-end mt-3">
            <h5>Grand Total Before VAT: Birr <span id="grand-total-before-vat">0.00</span></h5>
            <h5>VAT (15%): Birr <span id="vat-total">0.00</span></h5>
            <h5>Grand Total After VAT: Birr <span id="grand-total-after-vat">0.00</span></h5>
            <h5>Amount in Words: <span id="amount-in-words">Zero</span></h5>
            <input type="hidden" name="grand_total_after_vat" id="grand-total-after-vat-input">
            <button type="submit" class="btn btn-primary w-100 mt-3">Create Invoice</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function addItemRow() {
        let row = `<tr>
        <td>
            <select class="form-select item-select" name="items[][item_id]" required>
                <option value="">Select Item</option>
                <?php while ($item = $items->fetch_assoc()): ?>
                <option value="<?= $item['item_id'] ?>" data-price="<?= $item['unit_price'] ?>">
                    <?= htmlspecialchars($item['item_description']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </td>
        <td><input type="text" name="items[][unit_price]" class="form-control price" readonly></td>
        <td><input type="number" name="items[][quantity]" class="form-control qty" required></td>
        <td><input type="text" name="items[][total_price]" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>
    </tr>`;

        $('#items-container').append(row);
        attachRowEvents();
    }

    function removeRow(btn) {
        $(btn).closest('tr').remove();
        calculateTotals();
    }

    function attachRowEvents() {
        $('.item-select').change(function() {
            let row = $(this).closest('tr');
            row.find('.price').val(formatNumber($(this).find('option:selected').data('price')));
            calculateTotals();
        });

        $('.qty').on('input', function() {
            calculateTotals();
        });
    }

    function calculateTotals() {
        let grandTotal = 0;
        $('.total').each(function() {
            let row = $(this).closest('tr');
            let price = parseFloat(row.find('.price').val().replace(/,/g, '')) || 0;
            let qty = parseFloat(row.find('.qty').val()) || 0;
            let total = price * qty;
            row.find('.total').val(formatNumber(total));
            grandTotal += total;
        });

        let vat = grandTotal * 0.15;
        let grandTotalAfterVAT = grandTotal + vat;
        $('#grand-total-before-vat').text(formatNumber(grandTotal));
        $('#vat-total').text(formatNumber(vat));
        $('#grand-total-after-vat').text(formatNumber(grandTotalAfterVAT));
        $('#amount-in-words').text(numberToWords(grandTotalAfterVAT));
    }

    function formatNumber(num) {
        return num.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
</script>