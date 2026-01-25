<?php include 'header.php'; ?>
<?php
// --------------------
// SESSION & ERRORS
// --------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --------------------
// DB CONNECTION
// --------------------
require 'db_connect.php';

// --------------------
// SHOW SUCCESS ABOVE HEADER
// --------------------
if (isset($_SESSION['success'])) {
    echo "<div style='padding:15px;background:#d4edda;color:#155724;border:1px solid #c3e6cb;text-align:center;'>
            {$_SESSION['success']}
          </div>";
    unset($_SESSION['success']);
}

$message = "";

// --------------------
// FORM SUBMIT
// --------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username     = trim($_POST['username'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $middle_name  = trim($_POST['middle_name'] ?? '');
    $first_name   = trim($_POST['first_name'] ?? '');
    $gender       = $_POST['gender'] ?? '';
    $telephone    = trim($_POST['telephone'] ?? '');
    $address      = trim($_POST['address'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $role         = $_POST['role'] ?? '';

    // --------------------
    // IMAGE (OPTIONAL)
    // --------------------
    $profile_image = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $upload_dir = "uploads/users/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $profile_image = uniqid("user_") . "." . $ext;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $profile_image);
    }

    // --------------------
    // VALIDATION
    // --------------------
    if (empty($username) || empty($last_name) || empty($first_name) || empty($email) || empty($password) || empty($gender) || empty($role)) {
        $message = "<div class='alert alert-danger'>Please fill all required fields.</div>";
    } else {
        // Check email
        $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Email already registered.</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $full_name = trim("$first_name $middle_name $last_name");

            // --------------------
            // INSERT USER
            // --------------------
            $sql = "
            INSERT INTO users
            (username, last_name, middle_name, first_name, email, telephone, address, name, password, role, gender)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("SQL Prepare Failed: " . $conn->error);
            }

            $stmt->bind_param(
                "sssssssssss",
                $username,
                $last_name,
                $middle_name,
                $first_name,
                $email,
                $telephone,
                $address,
                $full_name,
                $hashed_password,
                $role,
                $gender
            );

            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful. Please login.";
                header("Location: register.php");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>{$stmt->error}</div>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Registration</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
/* --------- Compact Form Styles --------- */
.register-wrapper {
    max-width: 520px;
    margin: 40px auto;
}

.register-card {
    padding: 22px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-control, select {
    font-size: 14px;
    padding: 8px 10px;
}

label {
    font-weight: 600;
    font-size: 13px;
}

.btn {
    padding: 10px;
    font-size: 15px;
}
</style>
</head>
<body>

<div class="container">
    <div class="register-wrapper">
        <?= $message ?>

        <form method="POST" enctype="multipart/form-data" class="card register-card">
            <h4 class="mb-3 text-center">User Registration</h4>

            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>

            <div class="row">
                <div class="col">
                    <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
                </div>
                <div class="col">
                    <input type="text" name="middle_name" class="form-control mb-2" placeholder="Middle Name">
                </div>
                <div class="col">
                    <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
                </div>
            </div>

            <select name="gender" class="form-control mb-2" required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>

            <input type="text" name="telephone" class="form-control mb-2" placeholder="Telephone">
            <input type="text" name="address" class="form-control mb-2" placeholder="Address">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <select name="role" class="form-control mb-2" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="salesperson">Salesperson</option>
                <option value="user">User</option>
            </select>

            <label>Profile Image (Optional)</label>
            <input type="file" name="profile_image" class="form-control mb-3">

            <button class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
</div>

</body>
<?php include 'footer.php'; ?>
</html>
