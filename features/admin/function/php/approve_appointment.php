<?php
include '../../../../db.php';

// Get the data from the POST request
$id = $_POST['appointment_id']; // Use appointment_id from the form
$owner_name = $_POST['owner_name'];
$email = $_POST['email'];
$service = $_POST['service'];
$contact_num = $_POST['contact_num'];
$barangay = $_POST['barangay'];
$pet_type = $_POST['pet_type'];
$breed = $_POST['breed'];
$age = $_POST['age'];
$payment = $_POST['payment'];
$appointment_time = $_POST['appointment_time'];
$appointment_date = $_POST['appointment_date'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$add_info = $_POST['add_info'];

// Insert into the approved_req table
$sql_insert = "INSERT INTO approved_req (id, owner_name, email, service, contact_num, barangay, pet_type, breed, age, payment, appointment_time, appointment_date, latitude, longitude, add_info) 
        VALUES ('$id', '$owner_name', '$email', '$service', '$contact_num', '$barangay', '$pet_type', '$breed', '$age', '$payment', '$appointment_time', '$appointment_date', '$latitude', '$longitude', '$add_info')";

if ($conn->query($sql_insert) === TRUE) {
    // After successful insertion, delete the appointment
    $sql_delete = "DELETE FROM appointment WHERE id = '$id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        // Redirect with a success message
        header("Location: ../../web/api/app-req.php?message=Appointment approved and deleted successfully");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    echo "Error inserting into approved_req: " . $conn->error;
}

$conn->close();
?>
