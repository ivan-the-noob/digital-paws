<?php
session_start();

// Redirect if not logged in or not an admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../users/web/api/login.php");
    exit();
}

include '../../../../db.php'; // Include your database connection file

$error = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $email, $role, $id);

    // Execute the statement and handle errors
    try {
        if ($stmt->execute()) {
            $successMessage = "User updated successfully!";
            // Optionally, redirect to a specific page after success
            header("Location: ../../web/api/admin-user.php?message=" . urlencode($successMessage));
            exit();
        } else {
            $error = "Error: Could not update user.";
        }
    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage(), 0); // Log error to error log
        $error = "Error: Could not update user. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
