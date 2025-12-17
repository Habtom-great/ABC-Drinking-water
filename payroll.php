<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";
$database = "abc_company"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert employee data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_employee'])) {
    $fullName = $_POST['full_name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $basicSalary = $_POST['basic_salary'];
    $otherTaxes = $_POST['other_taxes'];

    $stmt = $conn->prepare("INSERT INTO payroll (full_name, position, department, basic_salary, other_taxes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdd", $fullName, $position, $department, $basicSalary, $otherTaxes);
    $stmt->execute();
    $stmt->close();
}

// Delete employee
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM payroll WHERE id = $delete_id");
}

// Retrieve payroll records from the database
$result = $conn->query("SELECT * FROM payroll");

// Payroll calculation function
function calculatePayroll($basicSalary, $otherTaxes) {
    $taxBrackets = [
        [600, 0, 0], [1650, 0.10, 60], [3200, 0.15, 142.50], [5250, 0.20, 302.50], 
        [7800, 0.25, 565], [10900, 0.30, 955], [PHP_INT_MAX, 0.35, 1500]
    ];

    $salaryTax = 0;
    foreach ($taxBrackets as $bracket) {
        if ($basicSalary <= $bracket[0]) {
            $salaryTax = ($basicSalary * $bracket[1]) - $bracket[2];
            break;
        }
    }

    $employeePension = $basicSalary * 0.07;
    $companyPension = $basicSalary * 0.11;
    $totalDeductions = $salaryTax + $employeePension + $otherTaxes;
    $netPay = $basicSalary - $totalDeductions;

    return [$salaryTax, $employeePension, $companyPension, $totalDeductions, $netPay];
}

// Calculate sum of columns
$totalSalary = $totalTax = $totalPensionEmployee = $totalPensionCompany = $totalOtherTaxes = $totalDeductions = $totalNetPay = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Employee Payroll</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
 body {
  background: #f4f4f4;
  font-family: Arial, sans-serif;
 }

 .container {
  margin: 50px auto;
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
 }

 table {
  margin-top: 20px;
 }

 th {
  background: #007bff;
  color: white;
 }

 tbody tr:nth-child(even) {
  background: #f2f2f2;
 }
 </style>
</head>

<body>
 <!-- Header -->
 <div class="header">
  Payroll Management - Admin Panel
 </div>

 <body>
  <a class="navbar-brand fw-bold" href="admin_dashboard.php">Admin Dashboard</a>
  <a href="manage_staff.php" class="btn btn-light me-2">Manage Staff</a>
  <a href="logout.php" class="btn btn-danger">Logout</a>
  <div class="container">
   <h2 class="text-center mb-4">Employee Payroll Management</h2>

   <!-- Employee Entry Form -->
   <form method="POST" class="mb-4">
    <div class="row">
     <div class="col-md-4">
      <label class="form-label">Full Name:</label>
      <input type="text" name="full_name" class="form-control" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Position:</label>
      <input type="text" name="position" class="form-control" required>
     </div>
     <div class="col-md-4">
      <label class="form-label">Department:</label>
      <input type="text" name="department" class="form-control" required>
     </div>
     <div class="col-md-4 mt-3">
      <label class="form-label">Basic Salary (ETB):</label>
      <input type="number" name="basic_salary" class="form-control" step="0.01" required>
     </div>
     <div class="col-md-4 mt-3">
      <label class="form-label">Other Taxes (ETB):</label>
      <input type="number" name="other_taxes" class="form-control" step="0.01" value="0">
     </div>
     <div class="col-md-4 mt-3">
      <button type="submit" name="add_employee" class="btn btn-primary mt-4">Add Employee</button>
     </div>
    </div>
   </form>

   <!-- Payroll Table -->
   <table class="table table-bordered text-center">
    <thead>
     <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Position</th>
      <th>Department</th>
      <th>Basic Salary (ETB)</th>
      <th>Gross Income (ETB)</th>
      <th>Income Tax (ETB)</th>
      <th>Employee Pension (7%)</th>
      <th>Company Pension (11%)</th>
      <th>Other Taxes (ETB)</th>
      <th>Total Deductions (ETB)</th>
      <th>Net Pay (ETB)</th>
      <th>Actions</th>
     </tr>
    </thead>
    <tbody>
     <?php while ($row = $result->fetch_assoc()): 
                    list($salaryTax, $employeePension, $companyPension, $totalDeductions, $netPay) = calculatePayroll($row['basic_salary'], $row['other_taxes']);
                    $totalSalary += $row['basic_salary'];
                    $totalTax += $salaryTax;
                    $totalPensionEmployee += $employeePension;
                    $totalPensionCompany += $companyPension;
                    $totalOtherTaxes += $row['other_taxes'];
                    $totalDeductions += $totalDeductions;
                    $totalNetPay += $netPay;
                ?>
     <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['full_name']) ?></td>
      <td><?= htmlspecialchars($row['position']) ?></td>
      <td><?= htmlspecialchars($row['department']) ?></td>
      <td><?= number_format($row['basic_salary'], 2) ?></td>
      <td><?= number_format($row['basic_salary'], 2) ?></td>
      <td><?= number_format($salaryTax, 2) ?></td>
      <td><?= number_format($employeePension, 2) ?></td>
      <td><?= number_format($companyPension, 2) ?></td>
      <td><?= number_format($row['other_taxes'], 2) ?></td>
      <td><?= number_format($totalDeductions, 2) ?></td>
      <td><strong><?= number_format($netPay, 2) ?></strong></td>
      <td>
       <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
       <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
        onclick="return confirm('Are you sure?')">Delete</a>
      </td>
     </tr>
     <?php endwhile; ?>
    </tbody>
    <tfoot>
     <tr>
      <th colspan="4">Total</th>
      <th><?= number_format($totalSalary, 2) ?></th>
      <th><?= number_format($totalSalary, 2) ?></th>
      <th><?= number_format($totalTax, 2) ?></th>
      <th><?= number_format($totalPensionEmployee, 2) ?></th>
      <th><?= number_format($totalPensionCompany, 2) ?></th>
      <th><?= number_format($totalOtherTaxes, 2) ?></th>
      <th><?= number_format($totalDeductions, 2) ?></th>
      <th><?= number_format($totalNetPay, 2) ?></th>
      <th></th>
     </tr>
    </tfoot>
   </table>
  </div>
 </body>

</html>