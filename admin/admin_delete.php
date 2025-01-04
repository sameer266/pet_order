<?php
session_start();
require_once "../connection.php";

// Check if the ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid request!";
    header("Location: admin_display.php");
    exit;
}

// Get the dog ID
$id = intval($_GET['id']); // Sanitize the ID

// Debugging: Check the received ID
// Uncomment the line below to check the value of the ID
// var_dump($id);

// Start a transaction for safe operations
$conn->begin_transaction();

try {
    // Step 1: Check if there are any references to this dog ID in the `cart` table
    $checkCartSQL = "SELECT COUNT(*) FROM cart WHERE dog_id = ?";
    $stmtCheckCart = $conn->prepare($checkCartSQL);
    $stmtCheckCart->bind_param("i", $id);
    $stmtCheckCart->execute();
    $stmtCheckCart->bind_result($cartCount);
    $stmtCheckCart->fetch();
    $stmtCheckCart->close();

    // If there are references in the cart, delete them first
    if ($cartCount > 0) {
        $deleteCartSQL = "DELETE FROM cart WHERE dog_id = ?";
        $stmtCart = $conn->prepare($deleteCartSQL);
        $stmtCart->bind_param("i", $id);
        if (!$stmtCart->execute()) {
            throw new Exception("Failed to delete dog from cart: " . $stmtCart->error);
        }
        $stmtCart->close();
    }

    // Step 2: Delete the dog record from the `dogs` table
    $deleteDogSQL = "DELETE FROM dogs WHERE id = ?";
    $stmtDog = $conn->prepare($deleteDogSQL);
    $stmtDog->bind_param("i", $id);
    if (!$stmtDog->execute()) {
        throw new Exception("Failed to delete dog: " . $stmtDog->error);
    }
    $stmtDog->close();

    // Commit the transaction if both queries succeed
    $conn->commit();

    $_SESSION['success'] = "Dog record deleted successfully.";
} catch (Exception $e) {
    // Rollback the transaction in case of any failure
    $conn->rollback();
    $_SESSION['error'] = "Failed to delete record: " . $e->getMessage();
    error_log("Error: " . $e->getMessage());  // Log the error for debugging
}

// Close the database connection
$conn->close();

// Redirect back to the admin display page
header("Location: admin_display.php");
exit;
?>
