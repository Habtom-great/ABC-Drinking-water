<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Dummy response (Replace this with actual database storage)
    echo "Registration successful! Name: $name, Email: $email";
}
?>


kkkkk

<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Include database connection
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input safely
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.'); window.location.href='login.php';</script>";
        exit();
    }

    // Prepare the SQL query to check credentials
    $sql = "SELECT user_id, email, password, name, role, gender FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('SQL Error: ' . $conn->error);
    }

    // Bind the email parameter to the query
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($user_id, $db_email, $db_password, $db_name, $db_role, $db_gender);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $db_password)) {
            // Store user details in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $db_name;
            $_SESSION['role'] = $db_role;
            $_SESSION['gender'] = $db_gender;

            // Redirect based on user role
            switch ($db_role) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'user':
                    header("Location: user_dashboard.php");
                    break;
                case 'staff':
                    header("Location: staff_dashboard.php");
                    break;
                case 'salesperson':
                        header("Location: salesperson_dashboard.php");
                        break;
                default:
                    echo "<script>alert('Unknown role. Please contact support.');</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email not found. Please register first.'); window.location.href='register.php';</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>