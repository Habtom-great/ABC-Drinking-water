<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'salesperson') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connection.php';

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'] ?? 'Salesperson';

// Fetch sales data from database
$sales_query = "SELECT COUNT(*) AS total_sales, SUM(total_sales) AS total_revenue FROM sales WHERE salesperson_id = ?";
$stmt = $conn->prepare($sales_query);

// Debug if prepare() fails
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_sales, $total_revenue);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesperson Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-banner {
            background: linear-gradient(90deg, #4e73df, #1cc88a);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .nav-link {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <div class="welcome-banner">
            <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
            <p>Your sales performance dashboard is here.</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text fs-3"><?php echo htmlspecialchars($total_sales ?? 0); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text fs-3">$<?php echo number_format($total_revenue ?? 0, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sales Target</h5>
                        <p class="card-text fs-3">$10,000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sales Table -->
        <div class="mt-4">
            <h2>Recent Sales</h2>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sales_table_query = "SELECT id, customer_name, total_sales, date FROM sales WHERE salesperson_id = ? ORDER BY date DESC LIMIT 5";
                    $stmt = $conn->prepare($sales_table_query);
                    if (!$stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . htmlspecialchars($row['customer_name']) . "</td>
                                <td>$" . number_format($row['total_sales'], 2) . "</td>
                                <td>" . htmlspecialchars($row['date']) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No recent sales</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Navigation Links -->
        <div class="mt-4">
            <a href="add_sale.php" class="btn btn-success btn-lg">Add Sale</a>
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Sales Management System</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
