<?php
include('db.php');
session_start();

// Authentication check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// CSRF protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialize variables
$search = $start_date = $end_date = '';
$where = [];
$params = [];
$types = '';

// Sorting configuration
$allowed_sort = ['invoice_no', 'invoice_date', 'item_id', 'item_description', 'total_purchased_after_vat'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_sort) ? $_GET['sort'] : 'invoice_no';
$order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

// Search functionality
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $where[] = "(invoice_no LIKE ? OR item_description LIKE ? OR item_id LIKE ? OR reference LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%", "%$search%"]);
    $types .= 'ssss';
}

// Date filtering
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
    
    $where[] = "(invoice_date BETWEEN ? AND ?)";
    $params = array_merge($params, [$start_date, $end_date]);
    $types .= 'ss';
}

// Build WHERE clause if conditions exist
$where_clause = '';
if (!empty($where)) {
    $where_clause = 'WHERE ' . implode(' AND ', $where);
}

// Pagination
$per_page = 15;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $per_page;

// Count total records
$count_sql = "SELECT COUNT(*) as total FROM inventory $where_clause";
$count_stmt = $conn->prepare($count_sql);

if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

// Fetch data with pagination
$sql = "SELECT * FROM inventory $where_clause ORDER BY $sort $order LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

// Add pagination parameters to existing params
$params = array_merge($params, [$per_page, $offset]);
$types .= 'ii';

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Calculate summary statistics
$summary_sql = "SELECT 
                COALESCE(SUM(quantity), 0) as total_quantity,
                COALESCE(SUM(total_purchased_before_vat), 0) as total_before_vat,
                COALESCE(SUM(vat), 0) as total_vat,
                COALESCE(SUM(total_purchased_after_vat), 0) as grand_total
                FROM inventory $where_clause";

$summary_stmt = $conn->prepare($summary_sql);
if (!empty($where)) {
    // For summary, we don't want the pagination parameters (last 2 elements)
    $summary_params = array_slice($params, 0, -2);
    $summary_types = substr($types, 0, -2);
    $summary_stmt->bind_param($summary_types, ...$summary_params);
}
$summary_stmt->execute();
$summary_result = $summary_stmt->get_result();
$summary = $summary_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <!-- ... [Head section remains the same] ... -->
</head>

<body>
 <div class="container">
  <!-- ... [Header and filter section remains the same] ... -->

  <!-- Summary Statistics -->
  <div class="summary-card no-print mb-4">
   <div class="row text-center">
    <div class="col-md-3 mb-3">
     <div class="card h-100">
      <div class="card-body">
       <h5 class="card-title">Total Quantity</h5>
       <p class="card-text summary-value"><?= number_format($summary['total_quantity']) ?></p>
      </div>
     </div>
    </div>
    <div class="col-md-3 mb-3">
     <div class="card h-100">
      <div class="card-body">
       <h5 class="card-title">Total Before VAT</h5>
       <p class="card-text summary-value"><?= number_format($summary['total_before_vat'], 2) ?></p>
      </div>
     </div>
    </div>
    <div class="col-md-3 mb-3">
     <div class="card h-100">
      <div class="card-body">
       <h5 class="card-title">Total VAT</h5>
       <p class="card-text summary-value"><?= number_format($summary['total_vat'], 2) ?></p>
      </div>
     </div>
    </div>
    <div class="col-md-3 mb-3">
     <div class="card h-100">
      <div class="card-body">
       <h5 class="card-title">Grand Total</h5>
       <p class="card-text summary-value"><?= number_format($summary['grand_total'], 2) ?></p>
      </div>
     </div>
    </div>
   </div>
  </div>

  <!-- ... [Rest of your HTML remains the same] ... -->
 </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Invoice Management System</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
 <style>
 :root {
  --primary-color: #2c3e50;
  --secondary-color: #34495e;
  --accent-color: #3498db;
  --success-color: #2ecc71;
  --warning-color: #f39c12;
  --danger-color: #e74c3c;
  --light-bg: #ecf0f1;
  --dark-text: #2c3e50;
  --light-text: #ecf0f1;
 }

 body {
  background-color: var(--light-bg);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--dark-text);
  padding: 20px;
 }

 .header-container {
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  padding: 2rem;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
  color: var(--light-text);
 }

 .table-container {
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  overflow: hidden;
 }

 .table thead th {
  background-color: var(--accent-color);
  color: white;
  position: sticky;
  top: 0;
  font-weight: 500;
 }

 .table th.sortable:hover {
  background-color: #2980b9;
  cursor: pointer;
 }

 .table tbody tr:hover {
  background-color: rgba(52, 152, 219, 0.05);
 }

 .badge-filter {
  background-color: var(--secondary-color);
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
 }

 .btn-action {
  transition: all 0.2s ease;
  margin: 0 2px;
  min-width: 80px;
 }

 .btn-action:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
 }

 .numeric-cell {
  text-align: right;
  font-family: 'Courier New', monospace;
 }

 .action-cell {
  white-space: nowrap;
 }

 @media (max-width: 768px) {
  .table-responsive {
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
  }

  .btn-group {
   flex-direction: column;
   gap: 5px;
  }

  .header-container {
   padding: 1.5rem;
  }
 }
 </style>
</head>

<body>
 <div class="container">
  <div class="header-container text-center">
   <h1><i class="bi bi-file-earmark-text"></i> Invoice Management</h1>
   <p class="lead mb-0">Total records: <?= number_format($total_records) ?></p>

   <?php if (!empty($search) || isset($_GET['start_date'])): ?>
   <div class="mt-3">
    <?php if (!empty($search)): ?>
    <span class="badge badge-filter">
     Search: "<?= htmlspecialchars($search) ?>"
     <a href="invoice_lists.php" class="text-white ms-2"><i class="bi bi-x"></i></a>
    </span>
    <?php endif; ?>

    <?php if (isset($_GET['start_date'])): ?>
    <span class="badge badge-filter">
     Date: <?= htmlspecialchars($_GET['start_date']) ?> to <?= htmlspecialchars($_GET['end_date'] ?? date('Y-m-d')) ?>
     <a href="invoice_lists.php" class="text-white ms-2"><i class="bi bi-x"></i></a>
    </span>
    <?php endif; ?>
   </div>
   <?php endif; ?>
  </div>

  <!-- Search and Filter -->
  <div class="card mb-4">
   <div class="card-body">
    <form method="GET" class="row g-3">
     <div class="col-md-6">
      <div class="input-group">
       <input type="text" class="form-control" name="search" placeholder="Search invoices..."
        value="<?= htmlspecialchars($search) ?>">
       <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Search</button>
      </div>
     </div>
     <div class="col-md-3">
      <input type="date" class="form-control" name="start_date"
       value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
     </div>
     <div class="col-md-3">
      <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
     </div>
     <div class="col-12">
      <div class="d-flex justify-content-between">
       <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Apply Filters</button>
       <a href="invoice_lists.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i>
        Reset</a>
       <a href="add_inventory.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> New Invoice</a>
      </div>
     </div>
    </form>
   </div>
  </div>

  <!-- Invoice Table -->
  <div class="table-container">
   <div class="table-responsive">
    <table class="table table-hover">
     <thead>
      <tr>
       <th class="sortable" onclick="sortTable('invoice_no')">
        Invoice No
        <?php if ($sort === 'invoice_no'): ?>
        <i class="bi bi-chevron-<?= $order === 'ASC' ? 'up' : 'down' ?>"></i>
        <?php endif; ?>
       </th>
       <th class="sortable" onclick="sortTable('invoice_date')">
        Date
        <?php if ($sort === 'invoice_date'): ?>
        <i class="bi bi-chevron-<?= $order === 'ASC' ? 'up' : 'down' ?>"></i>
        <?php endif; ?>
       </th>
       <th>Reference</th>
       <th>Item ID</th>
       <th>Description</th>
       <th class="numeric-cell">Qty</th>
       <th class="numeric-cell">Unit Cost</th>
       <th class="numeric-cell">Subtotal</th>
       <th class="numeric-cell">VAT</th>
       <th class="numeric-cell">Total</th>
       <th class="action-cell">Actions</th>
      </tr>
     </thead>
     <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
       <td><?= htmlspecialchars($row['invoice_no']) ?></td>
       <td><?= date('d/m/Y', strtotime($row['invoice_date'])) ?></td>
       <td><?= htmlspecialchars($row['reference']) ?></td>
       <td><?= htmlspecialchars($row['item_id']) ?></td>
       <td><?= htmlspecialchars($row['item_description']) ?></td>
       <td class="numeric-cell"><?= number_format($row['quantity']) ?></td>
       <td class="numeric-cell"><?= number_format($row['unit_cost'], 2) ?></td>


       <td class="action-cell">
        <div class="btn-group btn-group-sm">
         <a href="invoice.php?invoice_no=<?= urlencode($row['invoice_no']) ?>" class="btn btn-action btn-success"
          title="Print">
          <i class="bi bi-printer"></i> Print
         </a>
         <a href="add_inventory.php?invoice_no=<?= urlencode($row['invoice_no']) ?>&edit=1"
          class="btn btn-action btn-warning" title="Edit">
          <i class="bi bi-pencil"></i> Edit
         </a>
         <a
          href="delete_invoice.php?invoice_no=<?= urlencode($row['invoice_no']) ?>&csrf_token=<?= $_SESSION['csrf_token'] ?>"
          class="btn btn-action btn-danger" title="Delete"
          onclick="return confirm('Are you sure you want to delete this invoice?');">
          <i class="bi bi-trash"></i> Delete
         </a>
        </div>
       </td>
      </tr>
      <?php endwhile; ?>
      <?php else: ?>
      <tr>
       <td colspan="11" class="text-center py-4 text-muted">
        <i class="bi bi-exclamation-circle fs-1"></i>
        <p class="mt-2">No invoices found</p>
        <?php if (!empty($search) || isset($_GET['start_date'])): ?>
        <a href="invoice_lists.php" class="btn btn-sm btn-outline-primary mt-2">
         Clear filters
        </a>
        <?php endif; ?>
       </td>
      </tr>
      <?php endif; ?>
     </tbody>
    </table>
   </div>
  </div>

  <!-- Pagination -->
  <?php if ($total_pages > 1): ?>
  <nav class="mt-4">
   <ul class="pagination justify-content-center">
    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
     <a class="page-link"
      href="?page=<?= $page-1 ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($search) ?>&start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>">
      <i class="bi bi-chevron-left"></i>
     </a>
    </li>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
     <a class="page-link"
      href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($search) ?>&start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>">
      <?= $i ?>
     </a>
    </li>
    <?php endfor; ?>

    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
     <a class="page-link"
      href="?page=<?= $page+1 ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($search) ?>&start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>">
      <i class="bi bi-chevron-right"></i>
     </a>
    </li>
   </ul>
  </nav>
  <?php endif; ?>
 </div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script>
 function sortTable(column) {
  const url = new URL(window.location.href);
  const sortParam = url.searchParams.get('sort');
  const orderParam = url.searchParams.get('order');

  let order = 'DESC';
  if (sortParam === column) {
   order = orderParam === 'DESC' ? 'ASC' : 'DESC';
  }

  url.searchParams.set('sort', column);
  url.searchParams.set('order', order);
  window.location.href = url.toString();
 }
 </script>
</body>

</html>