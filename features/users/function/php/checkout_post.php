<?php
    session_start();
require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve POST data
    $name = $_POST['name'];
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : null; 
    $contact_num = $_POST['contact-num'];
    $address_search = $_POST['address-search'];
    $payment_method = $_POST['paymentMethod'];
    $screenshot = isset($_FILES['screenshot']) ? $_FILES['screenshot']['name'] : null;  // Handle file input
    $reference_id = isset($_POST['reference']) ? $_POST['reference'] : null;

    // Product info
    $product_name = $_POST['product_name'];  // Ensure to retrieve the product name(s) from the form
    $quantity = $_POST['quantity'];
    $sub_total = $_POST['sub-total'];
    $shipping_fee = $_POST['shipping-fee'];
    $total_amount = $_POST['total-amount'];
    $product_img = $_POST['product_img'];  // Retrieve the product image

    // Handle file upload if screenshot is provided
    if ($screenshot) {
        // Handle file upload, move it to the desired folder
        $upload_dir = "../../../../assets/img/product";
        $upload_file = $upload_dir . basename($_FILES["screenshot"]["name"]);
        move_uploaded_file($_FILES["screenshot"]["tmp_name"], $upload_file);
    }

    // SQL Query to Insert Data into Checkout Table
   $sql = "INSERT INTO checkout (name, email, contact_num, address_search, payment_method, screenshot, reference_id, product_name, quantity, sub_total, shipping_fee, total_amount, product_img)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssdddss", $name, $email, $contact_num, $address_search, $payment_method, $screenshot, $reference_id, $product_name, $quantity, $sub_total, $shipping_fee, $total_amount, $product_img);

    // Execute statement
    if ($stmt->execute()) {
        echo "Order successfully processed!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
