<?php
require '../../../../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['id'];

    $stmt = $conn->prepare("SELECT product_img, product_name, description, cost, type FROM product WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentImg = $row['product_img'];
    } else {
        echo "Product not found.";
        exit();
    }


    $productImg = $currentImg;

    // Handle file upload for product image
    if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] == 0) {
        $productImg = $_FILES['product_img']['name'];
        $targetDir = "../../../../assets/img/product/"; // Update with your actual path
        $targetFile = $targetDir . basename($productImg);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES['product_img']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (optional, e.g., 5MB limit)
        if ($_FILES['product_img']['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Attempt to upload the file if all checks are passed
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES['product_img']['tmp_name'], $targetFile)) {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Prepare SQL statement to update the product details
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    $type = $_POST['type'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE product SET product_img=?, product_name=?, description=?, cost=?, type=? WHERE id=?");
    $stmt->bind_param("sssssi", $productImg, $productName, $description, $cost, $type, $productId);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to product.php after successful update
        header("Location: ../../web/api/product.php");
        exit(); // Make sure to exit after the redirect
    } else {
        // Output error message
        echo "Error updating product: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
