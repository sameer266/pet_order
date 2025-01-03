<?php
session_name('petpal_session'); // Ensure you use a unique session name for your project
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: ../index.php'); // Redirect to the home page or login page
exit;
?>
