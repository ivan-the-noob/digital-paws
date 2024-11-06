<?php

require '../../../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Get the form data from hidden inputs
    $name = $_POST['name'];
    $contactNum = $_POST['contact-num'];
    $addressSearch = $_POST['address-search'];
    $paymentMethod = $_POST['paymentMethod'];
    $screenshot = $_FILES['screenshot']['name'] ?? '';
    $referenceId = $_POST['reference'] ?? '';
    $productName = $_POST['product-name'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    $subTotal = $_POST['sub-total'];
    $shippingFee = $_POST['shipping-fee'];
    $totalAmount = $_POST['total-amount'];

    echo "<h3>Checkout Details</h3>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Contact Number:</strong> $contactNum</p>";
    echo "<p><strong>Address:</strong> $addressSearch</p>";
    echo "<p><strong>Payment Method:</strong> $paymentMethod</p>";
    echo "<p><strong>Screenshot:</strong> $screenshot</p>";
    echo "<p><strong>Reference ID:</strong> $referenceId</p>";
    echo "<p><strong>Product Name:</strong> $productName</p>";
    echo "<p><strong>Size:</strong> $size</p>";
    echo "<p><strong>Quantity:</strong> $quantity</p>";
    echo "<p><strong>Cost:</strong> ₱$cost</p>";
    echo "<p><strong>Subtotal:</strong> ₱$subTotal</p>";
    echo "<p><strong>Shipping Fee:</strong> ₱$shippingFee</p>";
    echo "<p><strong>Total Amount:</strong> ₱$totalAmount</p>";

    // Upload screenshot if exists
    if ($screenshot) {
        move_uploaded_file($_FILES['screenshot']['tmp_name'], 'uploads/' . $screenshot);
    }

    // Insert data into the database
    $sql = "INSERT INTO checkout (name, contact_num, address_search, payment_method, screenshot, reference_id, product_name, size, quantity, cost, sub_total, shipping_fee, total_amount)
            VALUES ('$name', '$contactNum', '$addressSearch', '$paymentMethod', '$screenshot', '$referenceId', '$productName', '$size', '$quantity', '$cost', '$subTotal', '$shippingFee', '$totalAmount')";

    if ($conn->query($sql) === TRUE) {
        echo "Checkout successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
