<?php
session_start();
require_once "../connection.php"; // Ensure this connects to the 'pet_order' database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

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
        // Sanitize user inputs
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Check admin table for login
        $sql = "SELECT * FROM admin WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['is_admin'] = true;

            // Redirect to admin dashboard
            header("Location: admin_display.php");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    } else {
        $_SESSION['validation_errors'] = $errors;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="input-container">
                <label for="email" class="icon"><i class="fas fa-user"></i></label>
                <input type="text" id="email" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <?php if (isset($_SESSION['validation_errors']['email'])): ?>
                    <span class="error"><?= $_SESSION['validation_errors']['email']; ?></span>
                    <?php unset($_SESSION['validation_errors']['email']); ?>
                <?php endif; ?>
            </div>

            <div class="input-container">
                <label for="password" class="icon"><i class="fas fa-lock"></i></label>
                <input type="password" id="password" name="password" placeholder="Password">
                <?php if (isset($_SESSION['validation_errors']['password'])): ?>
                    <span class="error"><?= $_SESSION['validation_errors']['password']; ?></span>
                    <?php unset($_SESSION['validation_errors']['password']); ?>
                <?php endif; ?>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
