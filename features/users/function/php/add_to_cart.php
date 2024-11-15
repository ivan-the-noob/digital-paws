<?php 
session_start();

require '../../../../db.php';

if (!isset($_SESSION['email'])) {
    die("User is not logged in.");
}

$productId = $_POST['product_id'];
$productName = $_POST['product_name'];
$productPrice = $_POST['product_price'];
$quantity = $_POST['quantity'];
$totalPrice = $_POST['total_price'];
$productImage = $_POST['product_image'];
$email = $_SESSION['email']; 

$sql = "INSERT INTO cart (product_id, product_name, product_price, quantity, total_price, product_image, email)
        VALUES ('$productId', '$productName', '$productPrice', '$quantity', '$totalPrice', '$productImage', '$email')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../web/api/cart.php?message=Product added to cart successfully.");
} else {
    header("Location: ../../web/api/cart.php?message=Error adding product to cart: " . $conn->error);
}

$conn->close();
?>