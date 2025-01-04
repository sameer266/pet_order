<?php
session_start();
require_once "../connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Initialize error array
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
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    }

    if (empty($errors)) {
        // Sanitize email
        $email = mysqli_real_escape_string($conn, $email);

        // Use prepared statements to securely query the database
        $sql = "SELECT * FROM customer WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);  // No hashing here
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['users_name'] = $user['name'];
            $_SESSION['is_login'] = true;
            header('Location: customer_index.php');
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
    <title>Login Page</title>
    <link rel="stylesheet" href="../customer/css/customer_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <h2><?= $_SESSION['error']; ?></h2>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-container">
                <label for="email" class="icon"><i class="fas fa-user"></i></label>
                <input type="text" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
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

        <a href="customer_register.php" class="signup">Don't have an account? Sign up here</a>
    </div>
</body>
</html>
