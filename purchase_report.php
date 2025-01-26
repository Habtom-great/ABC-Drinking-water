<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Purchase & Sales Section -->
        <div class="col-lg-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="card-title mb-0">Purchase & Sales</h5>
                    <div class="graph-sets">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><span class="badge bg-light text-dark">Sales</span></li>
                            <li class="list-inline-item"><span class="badge bg-light text-dark">Purchase</span></li>
                        </ul>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                2022 <img src="assets/img/icons/dropdown.svg" alt="Dropdown Icon" class="ms-2">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="dropdown-item">2022</a></li>
                                <li><a href="#" class="dropdown-item">2021</a></li>
                                <li><a href="#" class="dropdown-item">2020</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales_charts"></div>
                </div>
            </div>
        </div>

        <!-- Recently Added Products Section -->
        <div class="col-lg-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                    <h4 class="card-title mb-0">Recently Added Products</h4>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="text-white">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="productlist.html" class="dropdown-item">Product List</a></li>
                            <li><a href="addproduct.html" class="dropdown-item">Add Product</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product22.jpg" alt="Apple Earpods" class="img-thumbnail" width="50">
                                            Apple Earpods
                                        </a>
                                    </td>
                                    <td>$891.2</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product23.jpg" alt="iPhone 11" class="img-thumbnail" width="50">
                                            iPhone 11
                                        </a>
                                    </td>
                                    <td>$668.51</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product24.jpg" alt="Samsung" class="img-thumbnail" width="50">
                                            Samsung
                                        </a>
                                    </td>
                                    <td>$522.29</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product6.jpg" alt="Macbook Pro" class="img-thumbnail" width="50">
                                            Macbook Pro
                                        </a>
                                    </td>
                                    <td>$291.01</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Products Section -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">Expired Products</h4>
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">IT0001</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product2.jpg" alt="Orange" class="img-thumbnail" width="50">
                                    Orange
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>12-12-2022</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">IT0002</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product3.jpg" alt="Pineapple" class="img-thumbnail" width="50">
                                    Pineapple
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>25-11-2022</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a href="#">IT0003</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product4.jpg" alt="Strawberry" class="img-thumbnail" width="50">
                                    Strawberry
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>19-11-2022</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><a href="#">IT0004</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product5.jpg" alt="Avocado" class="img-thumbnail" width="50">
                                    Avocado
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>20-11-2022</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Purchase & Sales Section -->
        <div class="col-lg-7 col-sm-12 col-12 d-flex">
            <div class="card flex-fill shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="card-title mb-0">Purchase & Sales</h5>
                    <div class="graph-sets">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><span class="badge bg-light text-dark">Sales</span></li>
                            <li class="list-inline-item"><span class="badge bg-light text-dark">Purchase</span></li>
                        </ul>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                2022 <img src="assets/img/icons/dropdown.svg" alt="Dropdown Icon" class="ms-2">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="dropdown-item">2022</a></li>
                                <li><a href="#" class="dropdown-item">2021</a></li>
                                <li><a href="#" class="dropdown-item">2020</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales_charts"></div>
                </div>
            </div>
        </div>

        <!-- Recently Added Products Section -->
        <div class="col-lg-5 col-sm-12 col-12 d-flex">
            <div class="card flex-fill shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                    <h4 class="card-title mb-0">Recently Added Products</h4>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="text-white">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="productlist.html" class="dropdown-item">Product List</a></li>
                            <li><a href="addproduct.html" class="dropdown-item">Add Product</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product22.jpg" alt="Apple Earpods" class="img-thumbnail" width="50">
                                            Apple Earpods
                                        </a>
                                    </td>
                                    <td>$891.2</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product23.jpg" alt="iPhone 11" class="img-thumbnail" width="50">
                                            iPhone 11
                                        </a>
                                    </td>
                                    <td>$668.51</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product24.jpg" alt="Samsung" class="img-thumbnail" width="50">
                                            Samsung
                                        </a>
                                    </td>
                                    <td>$522.29</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <a href="productlist.html">
                                            <img src="assets/img/product/product6.jpg" alt="Macbook Pro" class="img-thumbnail" width="50">
                                            Macbook Pro
                                        </a>
                                    </td>
                                    <td>$291.01</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Products Section -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">Expired Products</h4>
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">IT0001</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product2.jpg" alt="Orange" class="img-thumbnail" width="50">
                                    Orange
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>12-12-2022</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">IT0002</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product3.jpg" alt="Pineapple" class="img-thumbnail" width="50">
                                    Pineapple
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>25-11-2022</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a href="#">IT0003</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product4.jpg" alt="Strawberry" class="img-thumbnail" width="50">
                                    Strawberry
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>19-11-2022</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><a href="#">IT0004</a></td>
                            <td>
                                <a href="productlist.html">
                                    <img src="assets/img/product/product5.jpg" alt="Avocado" class="img-thumbnail" width="50">
                                    Avocado
                                </a>
                            </td>
                            <td>N/A</td>
                            <td>Fruits</td>
                            <td>20-11-2022</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: 600;
            color: #4a4a4a;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        .product-img img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }

        .dataview {
            margin-top: 20px;
        }

        .btn-white {
            color: #4a4a4a;
            border-color: #e0e0e0;
        }

        .btn-white:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Purchase & Sales Section -->
        <div class="col-lg-7 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Purchase & Sales</h5>
                    <div class="dropdown">
                        <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            2022 <img src="assets/img/icons/dropdown.svg" alt="dropdown">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                            <li><a class="dropdown-item" href="#">2022</a></li>
                            <li><a class="dropdown-item" href="#">2021</a></li>
                            <li><a class="dropdown-item" href="#">2020</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales_charts" style="height: 250px;"></div>
                </div>
            </div>
        </div>

        <!-- Recently Added Products Section -->
        <div class="col-lg-5 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recently Added Products</h5>
                    <div class="dropdown">
                        <a href="#" class="text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="productlist.html">Product List</a></li>
                            <li><a class="dropdown-item" href="addproduct.html">Add Product</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Products</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product22.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">Apple Earpods</a>
                                </td>
                                <td>$891.2</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product23.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">iPhone 11</a>
                                </td>
                                <td>$668.51</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product24.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">Samsung</a>
                                </td>
                                <td>$522.29</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="productimgname">
                                    <a href="productlist.html" class="product-img">
                                        <img src="assets/img/product/product6.jpg" alt="product">
                                    </a>
                                    <a href="productlist.html">Macbook Pro</a>
                                </td>
                                <td>$291.01</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Products Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Expired Products</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SNo</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Brand Name</th>
                                <th>Category</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>IT0001</td>
                                <td>Orange</td>
                                <td>N/A</td>
                                <td>Fruits</td>
                                <td>12-12-2022</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>IT0002</td>
                                <td>Pineapple</td>
                                <td>N/A</td>
                                <td>Fruits</td>
                                <td>25-11-2022</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>IT0003</td>
                                <td>Strawberry</td>
                                <td>N/A</td>
                                <td>Fruits</td>
                                <td>19-11-2022</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>IT0004</td>
                                <td>Avocado</td>
                                <td>N/A</td>
                                <td>Fruits</td>
                                <td>20-11-2022</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="assets/js/script.js"></script>
<script>
    // Initialize sales charts (Example)
    var options = {
        chart: {
            type: 'line',
            height: '250px'
        },
        series: [
            {
                name: 'Sales',
                data: [10, 20, 30, 40, 50]
            },
            {
                name: 'Purchase',
                data: [15, 25, 35, 45, 55]
            }
        ],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']
        }
    };
    var chart = new ApexCharts(document.querySelector("#sales_charts"), options);
    chart.render();
</script>
</body>
</html>
