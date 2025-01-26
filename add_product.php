<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Add</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
    }

    .page-wrapper {
      padding: 20px;
    }

    .page-header {
      margin-bottom: 20px;
    }

    .card {
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      padding: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .btn-submit, .btn-cancel {
      width: 150px;
      border-radius: 5px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .btn-submit {
      background-color: #28a745;
      color: white;
    }

    .btn-submit:hover {
      background-color: #218838;
    }

    .btn-cancel {
      background-color: #dc3545;
      color: white;
    }

    .btn-cancel:hover {
      background-color: #c82333;
    }

    .image-upload {
      border: 2px dashed #6c757d;
      border-radius: 5px;
      padding: 40px;
      text-align: center;
      background-color: #f8f9fa;
    }

    .image-upload input[type="file"] {
      display: none;
    }

    .image-upload img {
      max-width: 100px;
      margin-bottom: 20px;
    }

    .image-uploads h4 {
      color: #6c757d;
    }

    .form-control, .select {
      border-radius: 5px;
      height: 40px;
      padding: 10px;
    }

    .col-lg-3 {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="page-wrapper">
  <div class="content">
    <div class="page-header">
      <div class="page-title">
        <h4>Product Add</h4>
        <h6>Create new product</h6>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
          <!-- Product Name -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" class="form-control" placeholder="Enter product name">
            </div>
          </div>
          
          <!-- Category -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Category</label>
              <select class="form-control select">
                <option>Choose Category</option>
                <option>Computers</option>
              </select>
            </div>
          </div>
          
          <!-- Sub Category -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Sub Category</label>
              <select class="form-control select">
                <option>Choose Sub Category</option>
                <option>Fruits</option>
              </select>
            </div>
          </div>
          
          <!-- Brand -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Brand</label>
              <select class="form-control select">
                <option>Choose Brand</option>
                <option>Brand</option>
              </select>
            </div>
          </div>
          
          <!-- Unit -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Unit</label>
              <select class="form-control select">
                <option>Choose Unit</option>
                <option>Unit</option>
              </select>
            </div>
          </div>

          <!-- SKU -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>SKU</label>
              <input type="text" class="form-control" placeholder="Enter SKU">
            </div>
          </div>

          <!-- Minimum Qty -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Minimum Qty</label>
              <input type="text" class="form-control" placeholder="Enter minimum quantity">
            </div>
          </div>

          <!-- Quantity -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control" placeholder="Enter quantity">
            </div>
          </div>

          <!-- Description -->
          <div class="col-lg-12">
            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" placeholder="Enter product description"></textarea>
            </div>
          </div>

          <!-- Tax -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Tax</label>
              <select class="form-control select">
                <option>Choose Tax</option>
                <option>2%</option>
              </select>
            </div>
          </div>

          <!-- Discount Type -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Discount Type</label>
              <select class="form-control select">
                <option>Percentage</option>
                <option>10%</option>
                <option>20%</option>
              </select>
            </div>
          </div>

          <!-- Price -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Price</label>
              <input type="text" class="form-control" placeholder="Enter price">
            </div>
          </div>

          <!-- Status -->
          <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
              <label>Status</label>
              <select class="form-control select">
                <option>Closed</option>
                <option>Open</option>
              </select>
            </div>
          </div>

          <!-- Product Image -->
          <div class="col-lg-12">
            <div class="form-group">
              <label>Product Image</label>
              <div class="image-upload">
                <input type="file" class="form-control">
                <div class="image-uploads">
                  <img src="assets/img/icons/upload.svg" alt="Upload Icon">
                  <h4>Drag and drop a file to upload</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <div class="col-lg-12">
            <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
            <a href="productlist.html" class="btn btn-cancel">Cancel</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
kkkkkkkkkkk
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .page-wrapper {
            background-color: #f7f8fc;
            padding: 20px;
        }
        .page-header h4 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .page-header h6 {
            font-size: 16px;
            color: #777;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #444;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #4e73df;
            outline: none;
        }
        .btn-submit, .btn-cancel {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
        .image-upload {
            position: relative;
            border: 2px dashed #ccc;
            border-radius: 6px;
            padding: 30px;
            text-align: center;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .image-upload:hover {
            border-color: #4e73df;
        }
        .image-upload input {
            display: none;
        }
        .image-upload h4 {
            font-size: 16px;
            color: #555;
        }
        .image-uploads img {
            width: 50px;
            margin-bottom: 10px;
        }
        .image-uploads h4 {
            font-size: 14px;
            color: #888;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>
