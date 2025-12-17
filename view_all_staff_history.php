<?php
include 'db_connection.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all staff records
$query = "SELECT * FROM staff ORDER BY hire_date DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching staff: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Staff History</title>

 <!-- CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

 <!-- JS Libraries -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

 <style>
 body {
  background-color: #f8f9fa;
  font-size: 13px;
 }

 .container {
  margin-top: 20px;
 }

 .header {
  background: linear-gradient(90deg, #007bff, #0056b3);
  color: white;
  padding: 10px;
  text-align: center;
  font-size: 18px;
  font-weight: bold;
  border-radius: 5px;
 }

 .footer {
  background: #343a40;
  color: white;
  text-align: center;
  padding: 10px;
  margin-top: 30px;
  font-size: 14px;
  border-radius: 5px;
 }

 .table-responsive {
  overflow-x: auto;
  background-color: white;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
 }

 .table thead {
  background-color: #007bff;
  color: white;
  text-align: center;
 }

 .table td,
 .table th {
  vertical-align: middle !important;
  word-wrap: break-word;
  white-space: normal;
  padding: 8px;
  font-size: 13px;
 }

 .profile-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #007bff;
 }

 .buttons-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
  margin-bottom: 10px;
 }

 .buttons-container .btn {
  font-size: 12px;
  padding: 6px 12px;
  border-radius: 5px;
 }

 .btn-logout {
  margin-left: auto;
 }

 h4.text-center {
  flex-grow: 1;
  margin-bottom: 10px;
  font-weight: bold;
  color: #333;
 }

 /* Make the table width responsive */
 .table {
  width: 100% !important;
 }

 .table th,
 .table td {
  white-space: nowrap;
  /* Prevent text wrapping */
  overflow: hidden;
  text-overflow: ellipsis;
  /* Add ellipsis if text overflows */
 }

 .table-responsive {
  overflow-x: auto;
  /* Allow horizontal scrolling if necessary */
 }

 .dataTables_wrapper .dataTables_length,
 .dataTables_wrapper .dataTables_filter {
  font-size: 14px;
 }
 </style>

</head>

<body>

 <div class="header">Staff History - Admin Panel</div>

 <div class="container">
  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
   <h4 class="text-center flex-grow-1">Staff History</h4>
   <div class="buttons-container">
    <a href="admin_dashboard.php" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
    <button id="exportExcel" class="btn btn-success btn-sm">Export to Excel</button>
    <button id="exportPDF" class="btn btn-danger btn-sm">Export to PDF</button>
    <button id="printTable" class="btn btn-primary btn-sm">Print</button>
    <a href="logout.php" class="btn btn-warning btn-sm btn-logout">Logout</a>
   </div>
  </div>

  <?php
    // Database connection
    include('db_connection.php');

    $sql = "SELECT * FROM staff"; // Adjust to your query for staff records
    $result = mysqli_query($conn, $sql);
    ?>

  <?php if (mysqli_num_rows($result) > 0): ?>
  <div class="table-responsive">
   <table id="staffTable" class="table table-striped table-hover table-bordered">
    <thead class="text-center">
     <tr>
      <th>Profile</th>
      <th>Staff ID</th>
      <th>Last Name</th>
      <th>Middle Name</th>
      <th>First Name</th>
      <th>Department</th>
      <th>Position</th>
      <th>Salary</th>
      <th>Email</th>
      <th>Telephone</th>
      <th>Hire Date</th>
      <th>Termination Date</th>
      <th>Experience</th>
      <th>Skills</th>
     </tr>
    </thead>
    <tbody>
     <?php while ($staff = mysqli_fetch_assoc($result)) : ?>
     <tr>
      <td><img src="<?= htmlspecialchars($staff['profile_image']); ?>" alt="Profile" class="profile-img"></td>
      <td><?= htmlspecialchars($staff['staff_id']); ?></td>
      <td><?= htmlspecialchars($staff['last_name']); ?></td>
      <td><?= htmlspecialchars($staff['middle_name']); ?></td>
      <td><?= htmlspecialchars($staff['first_name']); ?></td>
      <td><?= htmlspecialchars($staff['department']); ?></td>
      <td><?= htmlspecialchars($staff['position']); ?></td>
      <td><?= number_format($staff['salary'], 2); ?></td>
      <td><?= htmlspecialchars($staff['email']); ?></td>
      <td><?= htmlspecialchars($staff['telephone']); ?></td>
      <td><?= htmlspecialchars($staff['hire_date']); ?></td>
      <td><?= htmlspecialchars($staff['termination_date']); ?></td>
      <td><?= htmlspecialchars($staff['experience']); ?> years</td>
      <td><?= htmlspecialchars($staff['skills']); ?></td>
     </tr>
     <?php endwhile; ?>
    </tbody>
   </table>
  </div>
  <?php else: ?>
  <p class="alert alert-warning text-center">No staff history available.</p>
  <?php endif; ?>
 </div>

 <div class="footer">ABC Company &copy; <?= date("Y"); ?> - Staff Management System</div>

 <script>
 $(document).ready(function() {
  var table = $('#staffTable').DataTable({


   lengthMenu: [
    [10, 25, 50, 100, -1],
    [10, 25, 50, 100, "All"]
   ],
   autoWidth: true,
   buttons: [{

     title: 'Staff History',
     exportOptions: {


     }
    },
    {

     title: 'Staff History',
     orientation: 'landscape',
     pageSize: 'A4',
     exportOptions: {

     }
    },
    {

     title: 'Staff History',
     exportOptions: {


     }
    }
   ],
   responsive: true
  });

  $('#exportExcel').on('click', function() {
   table.button(0).trigger();
  });
  $('#exportPDF').on('click', function() {
   table.button(1).trigger();
  });
  $('#printTable').on('click', function() {
   table.button(2).trigger();
  });
 });
 </script>

</body>

</html>