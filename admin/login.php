 <?php
 session_start();
require_once "connection.php"; 

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Role can be 'customer' or 'admin'

    $errors = [];

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($conn, $email);
        $hashedPassword = $password; // Use password_hash() for better security

        if ($role === "customer") {
            // Query the customer table
            $sql = "SELECT * FROM customer WHERE email = ? AND password = ?";
        } elseif ($role === "admin") {
            // Query the admin table
            $sql = "SELECT * FROM admin WHERE email = ? AND password = ?";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['users_name'] = $user['name'];
            $_SESSION['is_login'] = true;

            // Redirect based on role
            if ($role === "customer") {
                header('Location: customer_index.php');
            } elseif ($role === "admin") {
                header('Location: admin_index.php');
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header('Location: customer/customer_login.php'); // Redirect back to customer login page
        }
    } else {
        $_SESSION['validation_errors'] = $errors;
        header('Location: customer/customer_login.php'); // Redirect back to customer login page
    }
}
?> -->
