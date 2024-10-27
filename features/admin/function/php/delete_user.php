<?php
session_start(); 

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../users/web/api/login.php"); // Redirect to login if not authorized
    exit();
}

require '../../../../db.php';

// Check if the ID is set and is a valid number
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $userId = $_POST['id'];

    // Prepare the SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    // Execute the statement
    if ($stmt->execute()) {
        // User deleted successfully
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        // Error deleting user
        $_SESSION['message'] = "Error: Could not delete user.";
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid user ID.";
}

// Close the database connection
$conn->close();

// Redirect back to the admin page (you can modify this to the correct URL)
header("Location: ../../../admin-user.php");
exit();
?>
