<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, dashboard, responsive, template, projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams POS Admin Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>

    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="Logo">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="Logo Small">
                </a>
                <a id="toggle_btn" href="javascript:void(0);"></a>
            </div>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <ul class="nav user-menu">
                <!-- Search -->
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search"><i class="fa fa-search"></i></a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <img src="assets/img/icons/closes.svg" alt="Close">
                                </div>
                            </div>
                            <button type="submit" class="btn"><img src="assets/img/icons/search.svg" alt="Search"></button>
                        </form>
                    </div>
                </li>

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="assets/img/icons/notification-bing.svg" alt="Notifications">
                        <span class="badge rounded-pill">4</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span>Notifications</span>
                            <a href="#" class="clear-noti">Clear All</a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img src="assets/img/profiles/avatar-02.jpg" alt="User">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><strong>John Doe</strong> added a new task <strong>Patient appointment booking</strong></p>
                                                <p class="noti-time">4 mins ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- More notifications... -->
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View All Notifications</a>
                        </div>
                    </div>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="assets/img/profiles/avatar-01.jpg" alt="User">
                            <span class="status online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avatar-01.jpg" alt="User"></span>
                                <div class="profilesets">
                                    <h6>John Doe</h6>
                                    <span>Admin</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a class="dropdown-item" href="profile.html"><i data-feather="user"></i> My Profile</a>
                        <a class="dropdown-item" href="generalsettings.html"><i data-feather="settings"></i> Settings</a>
                        <hr>
                        <a class="dropdown-item logout" href="signin.html"><i data-feather="log-out"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li><a href="index.html"><img src="assets/img/icons/dashboard.svg" alt="Dashboard"> Dashboard</a></li>
                        <!-- Additional sidebar items here -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Sidebar -->
    </div>

    <!-- JS Files -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
Purchase 


kkk
<?php
function convertNumberToWords($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion'
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // Overflow
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyName = $_POST['companyName'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $invoiceNo = $_POST['invoiceNo'];
    $vat = $_POST['vat'];
    $withhold = $_POST['withhold'];
    $items = $_POST['itemId'];
    $descriptions = $_POST['description'];
    $uoms = $_POST['uom'];
    $qtys = $_POST['qty'];
    $unitCosts = $_POST['unitCost'];

    $invoiceDetails = [
        'Company Name' => $companyName,
        'Address' => $address,
        'Date' => $date,
        'Invoice No' => $invoiceNo,
        'Sub Total' => 0,
        'VAT (%)' => $vat,
        'VAT Amount' => 0,
        'Withhold' => $withhold,
        'Net Total' => 0,
        'Items' => []
    ];

    $subTotal = 0;

    foreach ($items as $key => $item) {
        $quantity = $qtys[$key];
        $unitCost = $unitCosts[$key];
        $totalCost = $quantity * $unitCost;

        $invoiceDetails['Items'][] = [
            'Item ID' => $item,
            'Description' => $descriptions[$key],
            'UoM' => $uoms[$key],
            'Quantity' => $quantity,
            'Unit Cost' => number_format($unitCost, 2),
            'Total Cost' => number_format($totalCost, 2),
        ];

        $subTotal += $totalCost;
    }

    $vatAmount = $subTotal * ($vat / 100);
    $netTotal = $subTotal + $vatAmount - $withhold;

    $invoiceDetails['Sub Total'] = number_format($subTotal, 2);
    $invoiceDetails['VAT Amount'] = number_format($vatAmount, 2);
    $invoiceDetails['Net Total'] = number_format($netTotal, 2);

    $invoiceDetails['Net Total in Words'] = convertNumberToWords($netTotal);

    echo "<pre>";
    print_r($invoiceDetails);
    echo "</pre>";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Purchase Order Form</h2>

        <!-- Form Start -->
        <form id="purchaseForm" action="#" method="POST">

            <div class="row mb-3">
                <label for="supplierName" class="col-sm-2 col-form-label">Supplier Name</label>
                <div class="col-sm-10">
                    <select id="supplierName" name="supplierName" class="form-select" required>
                        <option value="" selected disabled>Select Supplier</option>
                        <option value="Supplier A">Supplier A</option>
                        <option value="Supplier B">Supplier B</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="purchaseDate" class="col-sm-2 col-form-label">Purchase Date</label>
                <div class="col-sm-10">
                    <input type="date" id="purchaseDate" name="purchaseDate" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="referenceNo" class="col-sm-2 col-form-label">Reference No.</label>
                <div class="col-sm-10">
                    <input type="text" id="referenceNo" name="referenceNo" class="form-control" placeholder="Enter Reference No.">
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Tax (%)</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="product[]" class="form-control" placeholder="Product Name" required></td>
                            <td><input type="number" name="quantity[]" class="form-control" value="1" min="1" oninput="calculateTotal(this)" required></td>
                            <td><input type="number" name="price[]" class="form-control" oninput="calculateTotal(this)" required></td>
                            <td><input type="number" name="discount[]" class="form-control" value="0" oninput="calculateTotal(this)"></td>
                            <td><input type="number" name="tax[]" class="form-control" value="0" oninput="calculateTotal(this)"></td>
                            <td><input type="text" name="total[]" class="form-control" readonly></td>
                            <td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mb-3">
                <label for="grandTotal" class="form-label">Grand Total ($):</label>
                <input type="text" id="grandTotal" class="form-control" readonly>
            </div>

            <div class="row mb-3">
                <label for="ledgerAccount" class="col-sm-2 col-form-label">Ledger Account</label>
                <div class="col-sm-10">
                    <select id="ledgerAccount" name="ledgerAccount" class="form-select" required>
                        <option value="" selected disabled>Select Account</option>
                        <option value="Cash/Bank">Cash/Bank</option>
                        <option value="Accounts Payable">Accounts Payable</option>
                        <option value="Expense Account">Expense Account</option>
                        <option value="Liability Account">Liability Account</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="supportingDocs" class="form-label">Attach Supporting Documents</label>
                <input type="file" id="supportingDocs" name="supportingDocs" class="form-control">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <!-- Form End -->

    </div>

    <script>
        // Add product row dynamically
        function addRow() {
            const table = document.querySelector('.table tbody');
            const newRow = table.rows[0].cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            table.appendChild(newRow);
        }

        // Delete product row
        function deleteRow(button) {
            const row = button.closest('tr');
            if (row.parentElement.children.length > 1) row.remove();
            calculateTotal();
        }

        // Calculate total for each product and update grand total
        function calculateTotal(element) {
            const row = element.closest('tr');
            const quantity = parseFloat(row.querySelector('[name="quantity[]"]').value || 0);
            const price = parseFloat(row.querySelector('[name="price[]"]').value || 0);
            const discount = parseFloat(row.querySelector('[name="discount[]"]').value || 0);
            const tax = parseFloat(row.querySelector('[name="tax[]"]').value || 0);

            let total = (quantity * price) - discount;
            total += total * (tax / 100);

            row.querySelector('[name="total[]"]').value = total.toFixed(2);

            let grandTotal = 0;
            document.querySelectorAll('[name="total[]"]').forEach(input => {
                grandTotal += parseFloat(input.value || 0);
            });
            document.getElementById('grandTotal').value = grandTotal.toFixed(2);
        }

        // Submit validation for required fields
        document.getElementById('purchaseForm').addEventListener('submit', function(event) {
            const ledgerAccount = document.getElementById('ledgerAccount').value;
            if (!ledgerAccount || !['Cash/Bank', 'Accounts Payable', 'Expense Account', 'Liability Account'].includes(ledgerAccount)) {
                alert('Please select a valid ledger account.');
                event.preventDefault();
            }
        });
    </script>

</body>

</html