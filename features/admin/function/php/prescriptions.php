<?php
include '../../../../db.php'; // Ensure this file has the correct connection settings

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent XSS
    $owner_name = htmlspecialchars($_POST['owner_name']);
    $date = htmlspecialchars($_POST['date']);
    $pet_name = htmlspecialchars($_POST['pet_name']);
    $age = htmlspecialchars($_POST['age']);

    // Check if the required fields are filled
    if (empty($owner_name) || empty($date) || empty($pet_name) || empty($age)) {
        die("Required fields are missing. Please fill all the necessary details.");
    }

    // Check if the array fields exist and sanitize
    $drug_names = isset($_POST['drug_name']) ? implode(",", array_map('htmlspecialchars', $_POST['drug_name'])) : ''; 
    $times = isset($_POST['time']) ? implode(",", array_map('htmlspecialchars', $_POST['time'])) : '';
    $prescriptions = isset($_POST['prescription']) ? implode(",", array_map('htmlspecialchars', $_POST['prescription'])) : '';
    $frequencies = isset($_POST['frequency']) ? implode(",", array_map('htmlspecialchars', $_POST['frequency'])) : '';
    $special_instructions = isset($_POST['special_instructions']) ? implode(",", array_map('htmlspecialchars', $_POST['special_instructions'])) : '';

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO prescriptions (owner_name, date, pet_name, age, drug_name, time, prescription, frequency, special_instructions) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Check if the prepare() failed
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "sssssssss",
        $owner_name,
        $date,
        $pet_name,
        $age,
        $drug_names, // Use the implode results here
        $times,      // Use the sanitized time input
        $prescriptions, // Use the implode results here
        $frequencies, // Use the implode results here
        $special_instructions // Use the implode results here
    );

    // Execute statement and check for success
    if ($stmt->execute()) {
        echo '<script>alert("Prescription information saved successfully."); window.location.href="/path/to/redirect.php";</script>';
    } else {
        echo "Error executing the statement: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
