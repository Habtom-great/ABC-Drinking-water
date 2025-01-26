<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card {
            margin: 15px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .welcome-message {
            font-size: 1.5rem;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: gray;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p class="welcome-message">Welcome, <?php echo $_SESSION['name']; ?></p>
    </div>
    
    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>

    <div class="container mt-5">
        <div class="row">
            <!-- User Management -->
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h4>User Management</h4>
                    </div>
                    <div class="card-body">
                        <p>Manage users, view details, and assign roles.</p>
                        <a href="manage_users.php" class="btn btn-primary">Go to User Management</a>
                    </div>
                </div>
            </div>

            <!-- Staff Management -->
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h4>Staff Management</h4>
                    </div>
                    <div class="card-body">
                        <p>Manage staff details and assign inventory tasks.</p>
                        <a href="manage_staff.php" class="btn btn-success">Go to Staff Management</a>
                    </div>
                </div>
            </div>

            <!-- Inventory Management -->
            <div class="col-md-4">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h4>Inventory Management</h4>
                    </div>
                    <div class="card-body">
                        <p>Track inventory, manage stock, and generate reports.</p>
                        <a href="inventory_management.php" class="btn btn-warning">Go to Inventory Management</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reports -->
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h4>Reports</h4>
                    </div>
                    <div class="card-body">
                        <p>Generate and view detailed reports of the system.</p>
                        <a href="generate_report.php" class="btn btn-info">View Reports</a>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="col-md-4">
                <div class="card border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h4>Settings</h4>
                    </div>
                    <div class="card-body">
                        <p>Configure system settings and user permissions.</p>
                        <a href="settings.php" class="btn btn-secondary">Go to Settings</a>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h4>Activity Log</h4>
                    </div>
                    <div class="card-body">
                        <p>View and track system activity logs.</p>
                        <a href="activity_log.php" class="btn btn-danger">View Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Inventory Management System</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


