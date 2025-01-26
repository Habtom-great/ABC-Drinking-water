<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abc_company";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $gender = trim($_POST['gender']);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($role) || empty($gender)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit();
    }

    $allowed_roles = ['admin', 'staff', 'salesperson', 'user'];
    if (!in_array($role, $allowed_roles)) {
        echo "<script>alert('Invalid role selected!'); window.history.back();</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database using a prepared statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $role, $gender);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration Successful! Redirecting to Login...');
                window.location.href='login.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Add CSS styles here */
    </style>
</head>
<body>
<div class="form-body">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Register Today</h3>
                    <p>Fill in the data below.</p>
                    <form class="requires-validation" novalidate method="POST">
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                            <div class="valid-feedback">Username field is valid!</div>
                            <div class="invalid-feedback">Username field cannot be blank!</div>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
                            <div class="valid-feedback">Email field is valid!</div>
                            <div class="invalid-feedback">Email field cannot be blank!</div>
                        </div>
                        <div class="col-md-12">
                            <select class="form-select mt-3" name="role" required>
                                <option selected disabled value="">Position</option>
                                <option value="user">User</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                                <option value="salesperson">Salesperson</option>
                            </select>
                            <div class="valid-feedback">You selected a position!</div>
                            <div class="invalid-feedback">Please select a position!</div>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="valid-feedback">Password field is valid!</div>
                            <div class="invalid-feedback">Password field cannot be blank!</div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="mb-3 mr-1" for="gender">Gender: </label>
                            <input type="radio" class="btn-check" name="gender" id="male" value="Male" required>
                            <label class="btn btn-sm btn-outline-secondary" for="male">Male</label>
                            <input type="radio" class="btn-check" name="gender" id="female" value="Female" required>
                            <label class="btn btn-sm btn-outline-secondary" for="female">Female</label>
                            <input type="radio" class="btn-check" name="gender" id="secret" value="Secret" required>
                            <label class="btn btn-sm btn-outline-secondary" for="secret">Secret</label>
                            <div class="valid-feedback mv-up">You selected a gender!</div>
                            <div class="invalid-feedback mv-up">Please select a gender!</div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                            <label class="form-check-label">I confirm that all data are correct</label>
                            <div class="invalid-feedback">Please confirm that the entered data are all correct!</div>
                        </div>
                        <div class="form-button mt-3">
                            <button id="submit" type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.requires-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
</body>
</html>

