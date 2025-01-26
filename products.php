
<?php include 'header.php'; 
var_dump($_POST);?>

<section class="products">
    <h2>Our Products</h2>
    <div class="product-gallery">
        
        <div class="product-item">
            <img src="assets/images/Dispenser.jpeg" alt="Water Dispensers">
            <h3>Water Dispensers</h3>
            <p>Convenient and sustainable water solutions for homes and offices.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/OIF (1).jpeg" alt="Special Product">
            <h3>Special Product</h3>
            <p>Innovative solutions tailored to your needs.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/OIF.jpeg" alt="Special Product">
            <h3>Special Product</h3>
            <p>Innovative solutions tailored to your needs.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/th.jpeg" alt="Special Product">
            <h3>Special Product</h3>
            <p>Innovative solutions tailored to your needs.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/OIP.jpeg" alt="Special Product">
            <h3>Special Product</h3>
            <p>Innovative solutions tailored to your needs.</p>
        </div>
        <div class="product-item">
            <img src="assets/images//th.jpeg" alt="Special Product">
            <h3>Special Product</h3>
            <p>Innovative solutions tailored to your needs.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/Premium Water Bottles.jpeg" alt="Premium Water Bottle">
            <h3>Premium Water Bottles</h3>
            <p>Experience the crisp, clean taste of our premium bottled water.</p>
        </div>
        <div class="product-item">
            <img src="assets/images/bulk water .jpeg" alt="Bulk Water">
            <h3>Bulk Water Supply</h3>
            <p>Perfect for events and businesses—available in various sizes.</p>
        </div>
    </div>
</section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
kkkkkkkkkk
<?php
require_once 'config.php';

// Fetch inventory data
$query = "SELECT product_id, product_name, unit_price, stock_quantity FROM products";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching inventory: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Inventory Management</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Stock Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['product_id']; ?></td>
                        <td><?= $row['product_name']; ?></td>
                        <td><?= $row['unit_price']; ?></td>
                        <td><?= $row['stock_quantity']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


