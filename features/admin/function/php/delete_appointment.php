<?php
include '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Ensure this matches the hidden input name in your form

    // Prepare and execute the SQL statement
    $sql = "DELETE FROM appointment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Close prepared statement
        $stmt->close();
        
        // Redirect with success message
        header("Location: ../../web/api/app-req.php?delete_message=Appointment deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    // Handle if the request method is not POST (optional)
    echo "Invalid request method.";
}
?>
