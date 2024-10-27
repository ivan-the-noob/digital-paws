<?php
require '../../../../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['id'];

    // Prepare SQL statement to delete the product
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $productId);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to product.php after successful deletion
        header("Location: ../../web/api/product.php");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
