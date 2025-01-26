<?php
// Database Connection
$host = 'localhost';
$db = 'ABC_company';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch Data
try {
    // Daily Summary
    $dailySummary = $conn->query("
        SELECT transaction_type, SUM(quantity) as total
        FROM transactions
        WHERE transaction_date = CURDATE()
        GROUP BY transaction_type
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Branch-Wise Transactions
    $branchSummary = $conn->query("
        SELECT branch_name, transaction_type, SUM(quantity) as total
        FROM transactions
        WHERE transaction_date = CURDATE()
        GROUP BY branch_name, transaction_type
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Top Items
    $topItems = $conn->query("
        SELECT item_name, SUM(quantity) as total
        FROM transactions
        WHERE transaction_date = CURDATE()
        GROUP BY item_name
        ORDER BY total DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Reports</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
</head>
<body>
    <header>
        <h1>Daily Inventory Reports</h1>
    </header>
    <main>
        <section class="report-section">
            <h2>Daily Summary</h2>
            <div class="summary-cards">
                <?php foreach ($dailySummary as $row): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($row['transaction_type']); ?></h3>
                        <p><?php echo htmlspecialchars($row['total']); ?> items</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="report-section">
            <h2>Branch-Wise Transactions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Transaction Type</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branchSummary as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['transaction_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section class="report-section">
            <h2>Top Items</h2>
            <canvas id="topItemsChart"></canvas>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Inventory Management System</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const topItems = <?php echo json_encode($topItems); ?>;

            const labels = topItems.map(item => item.item_name);
            const data = topItems.map(item => item.total);

            const ctx = document.getElementById('topItemsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Top Items',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
<style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

header {
    background-color: #4CAF50;
    color: white;
    text-align: center;
    padding: 10px;
}

h1, h2 {
    margin: 10px 0;
    color: #333;
}

main {
    padding: 20px;
}

.report-section {
    margin-bottom: 30px;
}

.summary-cards {
    display: flex;
    gap: 15px;
    justify-content: space-around;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 30%;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #4CAF50;
    color: white;
}
          
</style>
kkkkkkkk
<?php
// Assuming a connection to the database is established
include('db_connection.php');

// Fetch inventory data
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error fetching inventory data: ' . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Inventory Report</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['item_id'] . "</td>";
                echo "<td>" . $row['item_name'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['unit_price'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="export_report.php">Export Report</a>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

kkkkkk
<?php
// Database Connection
$host = 'localhost';
$db = 'ABC_company';
$user = 'root';
$pass = '';
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Filter Options
$branches = $conn->query("SELECT DISTINCT branch_name FROM transactions")->fetchAll(PDO::FETCH_ASSOC);
$productTypes = $conn->query("SELECT DISTINCT transaction_type FROM transactions")->fetchAll(PDO::FETCH_ASSOC);
$salesPersonName = $conn->query("SELECT DISTINCT salesperson_name FROM transactions")->fetchAll(PDO::FETCH_ASSOC);


// Initialize Filters
$dateFrom = $_GET['date_from'] ?? '';
$dateTo = $_GET['date_to'] ?? '';
$productType = $_GET['product_type'] ?? '';
$branch = $_GET['branch'] ?? '';
$salesperson_name = $_GET['salesperson_name'] ?? '';

// Build Query with Filters
$query = "SELECT * FROM transactions WHERE 1=1";
$params = [];

if (!empty($dateFrom) && !empty($dateTo)) {
    $query .= " AND transaction_date BETWEEN :dateFrom AND :dateTo";
    $params[':dateFrom'] = $dateFrom;
    $params[':dateTo'] = $dateTo;
}

if (!empty($productType)) {
    $query .= " AND transaction_type = :productType";
    $params[':productType'] = $productType;
}

if (!empty($branch)) {
    $query .= " AND branch_name = :branch";
    $params[':branch'] = $branch;
}

if (!empty($salesRep)) {
    $query .= " AND sales_rep = :salesRep";
    $params[':salesRep'] = $salesRep;
}

$transactions = $conn->prepare($query);
$transactions->execute($params);
$results = $transactions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Inventory Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Filtered Inventory Report</h1>
        <p class="report-date">Date: <?php echo date('F j, Y'); ?></p>
    </header>
    <main>
        <section class="filter-section">
            <form method="GET" action="">
                <div class="filter-group">
                    <label for="date_from">Date From:</label>
                    <input type="date" id="date_from" name="date_from" value="<?php echo htmlspecialchars($dateFrom); ?>">

                    <label for="date_to">Date To:</label>
                    <input type="date" id="date_to" name="date_to" value="<?php echo htmlspecialchars($dateTo); ?>">
                </div>

                <div class="filter-group">
                    <label for="product_type">Product Type:</label>
                    <select id="product_type" name="product_type">
                        <option value="">All</option>
                        <?php foreach ($productTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type['transaction_type']); ?>" <?php echo ($type['transaction_type'] === $productType) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type['transaction_type']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="branch">Branch:</label>
                    <select id="branch" name="branch">
                        <option value="">All</option>
                        <?php foreach ($branches as $branchOption): ?>
                            <option value="<?php echo htmlspecialchars($branchOption['branch_name']); ?>" <?php echo ($branchOption['branch_name'] === $branch) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($branchOption['branch_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sales_rep">Sales Representative:</label>
                    <select id="sales_rep" name="sales_rep">
                        <option value="">All</option>
                        <?php foreach ($salesReps as $rep): ?>
                            <option value="<?php echo htmlspecialchars($rep['sales_rep']); ?>" <?php echo ($rep['sales_rep'] === $salesRep) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($rep['sales_rep']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="filter-btn">Filter</button>
            </form>
        </section>

        <section class="report-section">
            <h2>Transactions Report</h2>
            <?php if (!empty($results)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Branch</th>
                            <th>Product Type</th>
                            <th>Salesperson</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['transaction_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['transaction_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['salesperson_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No transactions found for the selected filters.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Inventory Management System</p>
    </footer>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        .filter-section {
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 800px;
            border-radius: 8px;
        }

        .filter-group {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        label {
            font-weight: bold;
        }

        input, select {
            padding: 8px;
            font-size: 1em;
            width: 100%;
            max-width: 200px;
        }

        .filter-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background-color: #45a049;
        }

        .report-section {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            margin: 20px 0;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #4CAF50;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</body>
</html>
kkkkkk
<?php
// Assuming a connection to the database is established
include('db_connection.php');

// Fetch inventory data
$query = "SELECT item_id, item_name, category, unit_price, unit_cost, beginning_qty, added_qty, sold_qty FROM inventory";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error fetching inventory data: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Inventory Report</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Unit Price</th>
                <th>Unit Cost</th>
                <th>Total Quantity</th>
                <th>Total Cost</th>
                <th>Total Price</th>
                <th>Beginning Qty</th>
                <th>Added Qty</th>
                <th>Sold Qty</th>
                <th>Remaining Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                // Initialize quantities to avoid undefined array key warnings
                $beginning_qty = (int)($row['beginning_qty'] ?? 0);
                $added_qty = (int)($row['added_qty'] ?? 0);
                $sold_qty = (int)($row['sold_qty'] ?? 0);
                $unit_price = (float)($row['unit_price'] ?? 0);
                $unit_cost = (float)($row['unit_cost'] ?? 0);

                // Calculations
                $total_qty = $beginning_qty + $added_qty - $sold_qty;
                $total_cost = $unit_cost * $total_qty;
                $total_price = $unit_price * $total_qty;
                $remaining_balance = $total_qty;

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td>" . number_format($unit_price, 2) . "</td>";
                echo "<td>" . number_format($unit_cost, 2) . "</td>";
                echo "<td>" . $total_qty . "</td>";
                echo "<td>" . number_format($total_cost, 2) . "</td>";
                echo "<td>" . number_format($total_price, 2) . "</td>";
                echo "<td>" . $beginning_qty . "</td>";
                echo "<td>" . $added_qty . "</td>";
                echo "<td>" . $sold_qty . "</td>";
                echo "<td>" . $remaining_balance . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="export_report.php">Export Report</a>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

kkkk
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Inventory Report</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
        .filter-section, .report-section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
        }
        input, select, button {
            padding: 8px;
            font-size: 1em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .no-data {
            color: #888;
            font-style: italic;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Filtered Inventory Report</h1>
        <p>Date: <?php echo date('F j, Y'); ?></p>
    </header>
    <main>
        <section class="filter-section">
            <form method="GET" action="">
                <div class="filter-group">
                    <label for="date_from">Date From:</label>
                    <input type="date" id="date_from" name="date_from" value="<?php echo htmlspecialchars($dateFrom); ?>">
                    
                    <label for="date_to">Date To:</label>
                    <input type="date" id="date_to" name="date_to" value="<?php echo htmlspecialchars($dateTo); ?>">
                </div>
                <div class="filter-group">
                    <label for="product_type">Product Type:</label>
                    <select id="product_type" name="product_type">
                        <option value="">All</option>
                        <?php foreach ($productTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type['transaction_type']); ?>" <?php echo ($type['transaction_type'] === $productType) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type['transaction_type']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="branch">Branch:</label>
                    <select id="branch" name="branch">
                        <option value="">All</option>
                        <?php foreach ($branches as $branchOption): ?>
                            <option value="<?php echo htmlspecialchars($branchOption['branch_name']); ?>" <?php echo ($branchOption['branch_name'] === $branch) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($branchOption['branch_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="sales_rep">Sales Representative:</label>
                    <select id="sales_rep" name="sales_rep">
                        <option value="">All</option>
                        <?php foreach ($salesReps as $rep): ?>
                            <option value="<?php echo htmlspecialchars($rep['salesperson_name']); ?>" <?php echo ($rep['salesperson_name'] === $salesRep) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($rep['salesperson_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Filter</button>
            </form>
        </section>
        
        <section class="report-section">
            <h2>Transactions Report</h2>
            <?php if (!empty($transactions)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Branch</th>
                            <th>Product Type</th>
                            <th>Salesperson</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['branch_name']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['transaction_type']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['salesperson_name']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No transactions found for the selected filters.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Inventory Management System</p>
    </footer>
</body>
</html>
