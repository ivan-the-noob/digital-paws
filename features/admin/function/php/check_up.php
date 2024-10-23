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
    $bcs = $_POST['bcs'];
    $stool = $_POST['stool'];
    $chief_complaint = $_POST['chief_complaint'];
    $treatment = $_POST['treatment'];
    $vomiting = $_POST['vomiting'];
    $ticks_fleas = $_POST['ticks_fleas'];
    $lepto = $_POST['lepto'];
    $chw = $_POST['chw'];
    $cpv = $_POST['cpv'];
    $cdv = $_POST['cdv'];
    $cbc = $_POST['cbc'];


    // Prepare SQL statement
    $sql = "INSERT INTO check_up (owner_name, date, address, active_number, pet_name, species, color, pet_birthdate, gender, breed, diet, bcs, stool, chief_complaint, treatment, vomiting, ticks_fleas, lepto, chw, cpv, cdv, cbc) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Check if the prepare() failed
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);  // Display the MySQL error
    }

    // Bind parameters
    $stmt->bind_param("ssssssssssssssssssssss", $owner_name, $date, $address, $active_number, $pet_name, $species, $color, $pet_birthdate, $gender, $breed, $diet, $bcs, $stool, $chief_complaint, $treatment, $vomiting, $ticks_fleas, $lepto, $chw, $cpv, $cdv, $cbc);

    // Execute statement and check for success
    if ($stmt->execute()) {
        header("Location: ../../web/api/check-up.php?message=Data saved successfully!");
        exit(); 
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
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
