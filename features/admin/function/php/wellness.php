<?php
include '../../../../db.php'; // Ensure this file has the correct connection settings

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $owner_name = $_POST['owner_name'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $active_number = $_POST['active_number'];
    $pet_name = $_POST['petName'];
    $species = $_POST['species'];
    $color = $_POST['petColor'];
    $pet_birthdate = $_POST['pet_birthdate'];
    $gender = $_POST['gender'];
    $breed = $_POST['breed'];
    $diet = $_POST['diet'];

    // Deworming data - convert arrays to comma-separated strings
    $date_given_dwrm = implode(',', $_POST['date_given_dwrm']);
    $weight_dwrm = implode(',', $_POST['weight_dwrm']);
    $treatment_dwrm = implode(',', $_POST['treatment_dwrm']);
    $observation_dwrm = implode(',', $_POST['observation_dwrm']);
    $follow_up_dwrm = implode(',', $_POST['follow_up_dwrm']);

    // Vaccination data - convert arrays to comma-separated strings
    $date_given_vac = implode(',', $_POST['date_given_vac']);
    $weight_vac = implode(',', $_POST['weight_vac']);
    $treatment_vac = implode(',', $_POST['treatment_vac']);
    $observation_vac = implode(',', $_POST['observation_vac']);
    $follow_up_vac = implode(',', $_POST['follow_up_vac']);

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
        die("Error preparing the statement: " . $conn->error); // Display the MySQL error
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
        // Redirect with a success message
        echo '<script>
            swal({
                title: "Success",
                text: "Check-up information saved successfully.",
                icon: "success",
                button: "OK"
            }).then(function() {
                window.location.href="../../path/to/redirect.php";
            });
        </script>';
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