<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $first_name = $_POST['first_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $address = $_POST['address'] ?? '';
    $name = $first_name . ' ' . $middle_name . ' ' . $last_name; // Full name
    $department = $_POST['department'] ?? '';
    $email = $_POST['email'] ?? '';
    $hire_date = $_POST['hire_date'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $educational_level = $_POST['educational_level'] ?? '';
    $major = $_POST['major'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $skills = $_POST['skills'] ?? '';
    $position = $_POST['position'] ?? '';

    // Handle file upload
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $profile_image = "";
    if (!empty($_FILES["profile_image"]["name"])) {
        $image_name = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $profile_image = $target_dir . $image_name;
        if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image)) {
            $profile_image = "";
        }
    }

    // SQL Insert Query
    $sql = "INSERT INTO staff 
            (first_name, middle_name, last_name, telephone, address, name, department, email, hire_date, profile_image, age, gender, educational_level, major, experience, skills, position) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters with the correct types: 
    // 's' for string, 'i' for integer
    // We assume all fields are strings except for age, which is integer.
    $stmt->bind_param(
        "sssssssssssssssss", 
        $first_name, $middle_name, $last_name, $telephone, $address, $name, $department, $email, 
        $hire_date, $profile_image, $age, $gender, $educational_level, $major, $experience, $skills, $position
    );

    if ($stmt->execute()) {
        // Redirect to the "Manage Staff" page
        header("Location: manage_staff.php");
        exit(); // Make sure the script stops executing after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Add New Staff</title>
 <link rel="stylesheet" href="assets/css/bootstrap.min.css">
 <style>
 body {
  background-color: #f4f7fc;
  font-family: 'Arial', sans-serif;
 }

 .header {
  background-color: #4e73df;
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 30px;
 }

 .navbar {
  margin-bottom: 30px;
 }

 .form-container {
  max-width: 350px;
  margin: auto;
  background: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
  margin-top: 10px;
 }

 .form-container h3 {
  color: #4e73df;
  margin-bottom: 20px;
 }

 .form-container input,
 .form-container select,
 .form-container textarea,
 .form-container button {
  font-size: 16px;
 }

 .form-container .btn-custom {
  background-color: #4e73df;
  color: white;
  font-weight: bold;
  padding: 12px;
  border-radius: 8px;
  width: 100%;
  text-align: center;
 }

 .form-container .btn-custom:hover {
  background-color: #375a8c;
 }

 .alert {
  margin-top: 15px;
  text-align: center;
 }

 .footer {
  background-color: #343a40;
  color: white;
  text-align: center;
  padding: 15px;
  margin-top: 50px;
 }

 .form-group label {
  font-weight: bold;
 }

 .form-group textarea {
  resize: vertical;
 }

 .profile-image {
  border-radius: 16px;
  width: 50px;
  height: 50px;
  object-fit: cover;
  margin-bottom: 15px;
 }

 .file-upload {
  background-color: #f4f7fc;
  padding: 10px;
  border-radius: 8px;
  display: inline-block;
  cursor: pointer;
 }
 </style>
</head>

<body>

 <!-- Header -->
 <div class="header">
  Add New Staff - Admin Panel
 </div>

 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
   <a class="navbar-brand fw-bold" href="admin_dashboard.php">Admin Dashboard</a>
   <div class="ml-auto">
    <a href="manage_staff.php" class="btn btn-light me-2">Manage Staff</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
   </div>
  </div>
 </nav>
 <!DOCTYPE html>
 <html lang="en">

 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Staff</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 </head>

 <body>

  <!-- Form Section -->
  <div class="form-container">
   <h3 class="text-center">✏️ Add New Staff</h3>
   <form method="post" enctype="multipart/form-data">

    <div class="form-group">

     <input type="file" name="profile_image" accept="image/*">

     <label></label>
     <img src="<?= isset($staff['profile_image']) ? $staff['profile_image'] : 'default.jpg' ?>" class="profile-image"
      alt="Profile Image">
     <div class="file-upload">
     </div>
     <div class="form-group">
      <label>Staff ID</label>
      <input type="text" class="form-control" value="<?= isset($staff['staff_id']) ? $staff['staff_id'] : '' ?>"
       readonly>

     </div>

     <div class="form-group">
      <label>First_name</label>
      <input type="text" name="first_name" class="form-control"
       value="<?= isset($staff['first_name']) ? $staff['first_name'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Middle_name</label>
      <input type="text" name="middle_name" class="form-control"
       value="<?= isset($staff['middle_name']) ? $staff['middle_name'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Last_name</label>
      <input type="text" name="last_name" class="form-control"
       value="<?= isset($staff['last_name']) ? $staff['last_name'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Department</label>
      <input type="text" name="department" class="form-control"
       value="<?= isset($staff['department']) ? $staff['department'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Position</label>
      <input type="text" name="position" class="form-control"
       value="<?= isset($staff['position']) ? $staff['position'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Salary</label>
      <input type="number" name="salary" class="form-control"
       value="<?= isset($staff['salary']) ? $staff['salary'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= isset($staff['email']) ? $staff['email'] : '' ?>"
       required>
     </div>
     <div class="form-group">
      <label>Telephone</label>
      <input type="text" name="telephone" class="form-control"
       value="<?= isset($staff['telephone']) ? $staff['telephone'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Address</label>
      <input type="text" name="address" class="form-control"
       value="<?= isset($staff['address']) ? $staff['address'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label for="role">Role</label>
      <select class="form-control" name="role" required>
       <option value="staff">Staff</option>
       <option value="salesperson">Salesperson</option> <!-- Added Salesperson role -->

      </select>
     </div>
     <div class="form-group">
      <label>Hire Date</label>
      <input type="date" name="hire_date" class="form-control"
       value="<?= isset($staff['hire_date']) ? $staff['hire_date'] : '' ?>" required>
     </div>
     <div class="form-group">
      <label>Termination Date</label>
      <input type="date" name="termination_date" class="form-control"
       value="<?= isset($staff['termination_date']) ? $staff['termination_date'] : '' ?>">
     </div>
     <div class="form-group">
      <label>Experience</label>
      <textarea name="experience" class="form-control"
       rows="4"><?= isset($staff['experience']) ? $staff['experience'] : '' ?></textarea>
     </div>
     <div class="form-group">
      <label>Skills</label>
      <textarea name="skills" class="form-control"
       rows="4"><?= isset($staff['skills']) ? $staff['skills'] : '' ?></textarea>
     </div>

    </div>
    <button type="submit" class="btn btn-custom">Add New Staff</button>
   </form>
  </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
   &copy; <?php echo date("Y"); ?> Add New Staff - All Rights Reserved.
  </footer>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
 </body>

 </html>
 <?php if ($success) {
            echo "<div class='alert alert-success'>$success</div>";
        } ?>
 <?php if ($error) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>