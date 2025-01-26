<?php
// Database Configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ABC_Company";

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        $this->conn->close();
    }
}

class InvoiceProcessor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    public function processInvoice($postData) {
        $conn = $this->db->getConnection();
        
        try {
            $conn->autocommit(FALSE);

            // Insert invoice header
            $invoiceId = $this->insertInvoiceHeader($conn, $postData);
            
            // Process items
            foreach ($postData['items'] as $item) {
                $this->processInvoiceItem($conn, $invoiceId, $item);
            }

            // Update totals
            $this->updateInvoiceTotals($conn, $invoiceId, $postData['grand_total']);

            $conn->commit();
            return ['success' => true, 'invoice_id' => $invoiceId];

        } catch (Exception $e) {
            $conn->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function insertInvoiceHeader($conn, $data) {
        $stmt = $conn->prepare("INSERT INTO invoices (invoice_no, reference, GL_account, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $data['invoice_no'], $data['reference'], $data['GL_account'], $data['grand_total']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    private function processInvoiceItem($conn, $invoiceId, $item) {
        // Insert invoice item
        $stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, item_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiddd", $invoiceId, $item['item_id'], $item['quantity'], $item['unit_price'], $item['total_price']);
        $stmt->execute();

        // Update inventory
        $updateStmt = $conn->prepare("UPDATE inventory SET sold_qty = sold_qty + ?, cost_of_sold = cost_of_sold + (? * unit_cost), quantity = quantity - ? WHERE item_id = ?");
        $updateStmt->bind_param("dddi", $item['quantity'], $item['quantity'], $item['quantity'], $item['item_id']);
        $updateStmt->execute();
    }

    private function updateInvoiceTotals($conn, $invoiceId, $grandTotal) {
        $stmt = $conn->prepare("UPDATE invoices SET grand_total = ? WHERE invoice_id = ?");
        $stmt->bind_param("di", $grandTotal, $invoiceId);
        $stmt->execute();
    }
}

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $processor = new InvoiceProcessor();
    $result = $processor->processInvoice($_POST);
    
    if ($result['success']) {
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        exit();
    } else {
        $error = $result['error'];
    }
}

// Get inventory items
$items = $conn->query("SELECT item_id, item_name, unit_price, quantity FROM inventory WHERE quantity > 0");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory & Invoice System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-container { max-width: 1000px; margin: 2rem auto; }
        .dynamic-row:hover { background-color: #f8f9fa; }
        .total-display { background-color: #e9ecef; padding: 1rem; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container invoice-container">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">Invoice created successfully!</div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Create Invoice</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label>Invoice Number</label>
                            <input type="text" name="invoice_no" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Reference</label>
                            <input type="text" name="reference" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>GL Account</label>
                            <input type="text" name="GL_account" class="form-control" required>
                        </div>
                    </div>

                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Item</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-container">
                            <template id="item-template">
                                <tr class="dynamic-row">
                                    <td>
                                        <select class="form-select item-select" name="items[][item_id]" required>
                                            <option value="">Select Item</option>
                                            <?php while($item = $items->fetch_assoc()): ?>
                                                <option value="<?= $item['item_id'] ?>" 
                                                    data-price="<?= $item['unit_price'] ?>"
                                                    data-stock="<?= $item['quantity'] ?>">
                                                    <?= $item['item_name'] ?> (Stock: <?= $item['quantity'] ?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </td>
                                    <td><input type="number" name="items[][unit_price]" class="form-control price" readonly></td>
                                    <td><input type="number" name="items[][quantity]" class="form-control qty" min="1" required></td>
                                    <td><input type="number" name="items[][total_price]" class="form-control total" readonly></td>
                                    <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">×</button></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-secondary" onclick="addItemRow()">Add Item</button>
                </div>

                <div class="card-footer">
                    <div class="total-display text-end">
                        <h4>Grand Total: $<span id="grand-total">0.00</span></h4>
                        <input type="hidden" name="grand_total" id="grand-total-input">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Create Invoice</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function addItemRow() {
            const template = document.getElementById('item-template');
            const clone = template.content.cloneNode(true);
            document.getElementById('items-container').appendChild(clone);
            attachRowEvents();
        }

        function removeRow(button) {
            button.closest('tr').remove();
            calculateTotals();
        }

        function attachRowEvents() {
            document.querySelectorAll('.item-select').forEach(select => {
                select.addEventListener('change', function() {
                    const price = this.options[this.selectedIndex].dataset.price;
                    this.closest('tr').querySelector('.price').value = price;
                });
            });

            document.querySelectorAll('.qty').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });
        }

        function calculateTotals() {
            let grandTotal = 0;
            document.querySelectorAll('.dynamic-row').forEach(row => {
                const price = parseFloat(row.querySelector('.price').value) || 0;
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const total = price * qty;
                row.querySelector('.total').value = total.toFixed(2);
                grandTotal += total;
            });
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            document.getElementById('grand-total-input').value = grandTotal.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', () => {
            addItemRow();
            attachRowEvents();
        });
    </script>
</body>
</html>