<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_company";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form or query parameters
$branch = isset($_POST['branch_id']) ? $_POST['branch_id'] : 'All';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
$section = isset($_POST['section']) ? $_POST['section'] : null;
$salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : null;

// Initialize totals
$total_quantity = 0;
$total_value = 0;

// Construct SQL query based on input
$query = "SELECT * FROM sales WHERE 1 = 1";

if ($branch !== 'All') {
    $query .= " AND branch = '" . $conn->real_escape_string($branch) . "'";
}
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND sale_date BETWEEN '" . $conn->real_escape_string($start_date) . "' AND '" . $conn->real_escape_string($end_date) . "'";
}
if (!empty($section)) {
    $query .= " AND section = '" . $conn->real_escape_string($section) . "'";
}
if (!empty($salesperson)) {
    $query .= " AND salesperson_id = '" . $conn->real_escape_string($salesperson) . "'";
}

// Execute the query
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 85%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-header h2, .report-header h3 {
            margin: 5px 0;
        }
        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>ABC Company</h1>
        <h2>Sales Report</h2>
        <h3>Branch: <?= htmlspecialchars($branch) ?></h3>
        <h3>Date Range: <?= htmlspecialchars($start_date ?: 'N/A') ?> to <?= htmlspecialchars($end_date ?: 'N/A') ?></h3>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Invoice No.</th>
                    <th>Item ID</th>
                    <th>Item Description</th>
                    <th>UOM</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Value</th>
                    <th>Salesperson ID</th>
                    <th>Salesperson Name</th>
                    <th>Branch</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Accumulate totals
                    $total_quantity += $row['quantity'];
                    $total_value += $row['total_price'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['sale_date']) ?></td>
                        <td><?= htmlspecialchars($row['reference']) ?></td>
                        <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                        <td><?= htmlspecialchars($row['item_id']) ?></td>
                        <td><?= htmlspecialchars($row['item_description']) ?></td>
                        <td><?= htmlspecialchars($row['uom']) ?></td>
                        <td><?= number_format($row['quantity'], 2) ?></td>
                        <td><?= number_format($row['unit_price'], 2) ?></td>
                        <td><?= number_format($row['total_price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['salesperson_id']) ?></td>
                        <td><?= htmlspecialchars($row['salesperson_name']) ?></td>
                        <td><?= isset($row['branch']) ? htmlspecialchars($row['branch']) : 'N/A' ?></td>
                        <td><?= htmlspecialchars($row['section']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right;">Total:</th>
                    <th><?= number_format($total_quantity, 2) ?></th>
                    <th></th>
                    <th><?= number_format($total_value, 2) ?></th>
                    <th colspan="3"></th>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No records found for the given criteria.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
kkkkkkkkkkk
<div class="page-wrapper">
                <div class="content">
                    <div class="page-header">
                        <div class="page-title">
                            <h4>Sale Details</h4>
                            <h6>View sale details</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Sale Info and Actions -->
                            <div class="card-sales-split mb-4">
                                <h2>Sale Detail: SL0101</h2>
                                <ul class="d-flex justify-content-start">
                                    <li><a href="javascript:void(0);"><img src="assets/img/icons/edit.svg" alt="Edit"></a></li>
                                    <li><a href="javascript:void(0);"><img src="assets/img/icons/pdf.svg" alt="PDF"></a></li>
                                    <li><a href="javascript:void(0);"><img src="assets/img/icons/excel.svg" alt="Excel"></a></li>
                                    <li><a href="javascript:void(0);"><img src="assets/img/icons/printer.svg" alt="Print"></a></li>
                                </ul>
                            </div>
            
                            <!-- Invoice Table -->
                            <div class="invoice-box" style="max-width: 1600px; width: 100%; overflow-x: auto; margin: 15px auto; padding: 0; font-size: 14px; line-height: 24px; color: #555;">
                                <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left;">
                                    <tbody>
                                        <tr class="top">
                                            <td colspan="6" style="padding: 5px; vertical-align: top;">
                                                <table style="width: 100%; text-align: left;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 5px; vertical-align: top; padding-bottom: 20px;">
                                                                <strong style="font-size: 14px; color: #7367F0;">Customer Info</strong><br>
                                                                <span style="font-size: 14px;">walk-in-customer</span><br>
                                                                <span style="font-size: 14px;">[email protected]</span><br>
                                                                <span style="font-size: 14px;">123456780</span><br>
                                                                <span style="font-size: 14px;">N45, Dhaka</span>
                                                            </td>
                                                            <td style="padding: 5px; vertical-align: top; padding-bottom: 20px;">
                                                                <strong style="font-size: 14px; color: #7367F0;">Company Info</strong><br>
                                                                <span style="font-size: 14px;">DGT</span><br>
                                                                <span style="font-size: 14px;">[email protected]</span><br>
                                                                <span style="font-size: 14px;">6315996770</span><br>
                                                                <span style="font-size: 14px;">3618 Abia Martin Drive</span>
                                                            </td>
                                                            <td style="padding: 5px; vertical-align: top; padding-bottom: 20px;">
                                                                <strong style="font-size: 14px; color: #7367F0;">Invoice Info</strong><br>
                                                                <span style="font-size: 14px;">Reference</span><br>
                                                                <span style="font-size: 14px;">Payment Status</span><br>
                                                                <span style="font-size: 14px;">Status</span>
                                                            </td>
                                                            <td style="padding: 5px; vertical-align: top; text-align: right; padding-bottom: 20px;">
                                                                <span style="font-size: 14px;">SL0101</span><br>
                                                                <span style="font-size: 14px; color: #2E7D32;">Paid</span><br>
                                                                <span style="font-size: 14px; color: #2E7D32;">Completed</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
            
                                        <!-- Table Header -->
                                        <tr class="heading" style="background: #F3F2F7;">
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">Product Name</td>
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">QTY</td>
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">Price</td>
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">Discount</td>
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">TAX</td>
                                            <td style="padding: 10px; font-weight: 600; color: #5E5873;">Subtotal</td>
                                        </tr>
            
                                        <!-- Product Rows -->
                                        <tr class="details" style="border-bottom: 1px solid #E9ECEF;">
                                            <td style="padding: 10px; display: flex; align-items: center;">
                                                <img src="assets/img/product/product1.jpg" alt="Macbook Pro" class="me-2" style="width: 40px; height: 40px;">
                                                Macbook Pro
                                            </td>
                                            <td style="padding: 10px;">1.00</td>
                                            <td style="padding: 10px;">1500.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">1500.00</td>
                                        </tr>
                                        <tr class="details" style="border-bottom: 1px solid #E9ECEF;">
                                            <td style="padding: 10px; display: flex; align-items: center;">
                                                <img src="assets/img/product/product7.jpg" alt="Apple Earpods" class="me-2" style="width: 40px; height: 40px;">
                                                Apple Earpods
                                            </td>
                                            <td style="padding: 10px;">1.00</td>
                                            <td style="padding: 10px;">2000.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">2000.00</td>
                                        </tr>
                                        <tr class="details" style="border-bottom: 1px solid #E9ECEF;">
                                            <td style="padding: 10px; display: flex; align-items: center;">
                                                <img src="assets/img/product/product8.jpg" alt="Samsung" class="me-2" style="width: 40px; height: 40px;">
                                                Samsung
                                            </td>
                                            <td style="padding: 10px;">1.00</td>
                                            <td style="padding: 10px;">8000.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">0.00</td>
                                            <td style="padding: 10px;">8000.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
            
                            <!-- Summary Section -->
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Order Tax</label>
                                        <input type="text" value="0.00">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Discount</label>
                                        <input type="text" value="0.00">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Shipping</label>
                                        <input type="text" value="0.00">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Grand Total</label>
                                        <input type="text" value="1000.00" readonly>
                                    </div>
                                </div>
                            </div>
            
                            <!-- Buttons -->
                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-sm me-2" type="submit">Submit</button>
                                <button class="btn btn-danger btn-sm" type="submit">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
