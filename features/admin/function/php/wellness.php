<?php
include '../../../../db.php'; // Ensure this file has the correct connection settings

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent XSS
    $owner_name = htmlspecialchars($_POST['owner_name']);
    $date = htmlspecialchars($_POST['date']);
    $address = htmlspecialchars($_POST['address']);
    $active_number = htmlspecialchars($_POST['active_number']);
    $pet_name = htmlspecialchars($_POST['petName']);
    $species = htmlspecialchars($_POST['species']);
    $color = htmlspecialchars($_POST['petColor']);
    $pet_birthdate = htmlspecialchars($_POST['pet_birthdate']);
    $gender = htmlspecialchars($_POST['gender']);
    $breed = htmlspecialchars($_POST['breed']);
    $diet = htmlspecialchars($_POST['diet']);

    // Check if the required fields are filled
    if (empty($owner_name) || empty($date) || empty($pet_name) || empty($species)) {
        die("Required fields are missing. Please fill all the necessary details.");
    }

    // Check if the array fields exist and sanitize
    $date_given_dwrm = isset($_POST['date_given_dwrm']) ? implode(",", array_map('htmlspecialchars', $_POST['date_given_dwrm'])) : '';
    $weight_dwrm = isset($_POST['weight_dwrm']) ? implode(",", array_map('htmlspecialchars', $_POST['weight_dwrm'])) : '';
    $treatment_dwrm = isset($_POST['treatment_dwrm']) ? implode(",", array_map('htmlspecialchars', $_POST['treatment_dwrm'])) : '';
    $observation_dwrm = isset($_POST['observation_dwrm']) ? implode(",", array_map('htmlspecialchars', $_POST['observation_dwrm'])) : '';
    $follow_up_dwrm = isset($_POST['follow_up_dwrm']) ? implode(",", array_map('htmlspecialchars', $_POST['follow_up_dwrm'])) : '';

    $date_given_vac = isset($_POST['date_given_vac']) ? implode(",", array_map('htmlspecialchars', $_POST['date_given_vac'])) : '';
    $weight_vac = isset($_POST['weight_vac']) ? implode(",", array_map('htmlspecialchars', $_POST['weight_vac'])) : '';
    $treatment_vac = isset($_POST['treatment_vac']) ? implode(",", array_map('htmlspecialchars', $_POST['treatment_vac'])) : '';
    $observation_vac = isset($_POST['observation_vac']) ? implode(",", array_map('htmlspecialchars', $_POST['observation_vac'])) : '';
    $follow_up_vac = isset($_POST['follow_up_vac']) ? implode(",", array_map('htmlspecialchars', $_POST['follow_up_vac'])) : '';

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO wellness (
        owner_name, date, address, active_number, pet_name, species, color, pet_birthdate, 
        gender, breed, diet, date_given_dwrm, weight_dwrm, treatment_dwrm, observation_dwrm, follow_up_dwrm, 
        date_given_vac, weight_vac, treatment_vac, observation_vac, follow_up_vac
    ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Check if the prepare() failed
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "sssssssssssssssssssss",
        $owner_name,
        $date,
        $address,
        $active_number,
        $pet_name,
        $species,
        $color,
        $pet_birthdate,
        $gender,
        $breed,
        $diet,
        $date_given_dwrm,
        $weight_dwrm,
        $treatment_dwrm,
        $observation_dwrm,
        $follow_up_dwrm,
        $date_given_vac,
        $weight_vac,
        $treatment_vac,
        $observation_vac,
        $follow_up_vac
    );

    // Execute statement and check for success
    if ($stmt->execute()) {
        // Redirect or display a success message
        echo '<script>alert("Check-up information saved successfully."); window.location.href="/path/to/redirect.php";</script>';
    } else {
        // Handle errors
        echo "Error executing the statement: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


<?php
// Check if the message parameter is set in the URL
if (isset($_GET['message'])) {
    // Escape the message to prevent XSS attacks
    $message = htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8');

    // Display the message using SweetAlert
    echo "<script>
        window.onload = function() {
            swal({
                title: 'Success',
                text: '$message',
                icon: 'success',  
                button: 'OK',
            });
        };
    </script>";
}
?>