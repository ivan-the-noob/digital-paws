<?php
include '../../../../db.php';

$checkupCards = ''; // Initialize variable for card content

$sql = "SELECT * FROM prescriptions"; // SQL query to fetch all prescriptions
$result = $conn->query($sql); // Execute the query

if ($result->num_rows > 0) {
    // Loop through each row fetched from the database
    while ($row = $result->fetch_assoc()) {
        // Sanitize the values for safety
        $ownerName = htmlspecialchars($row['owner_name'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8');
        $pet_name = htmlspecialchars($row['pet_name'], ENT_QUOTES, 'UTF-8');
        $age = htmlspecialchars($row['age'], ENT_QUOTES, 'UTF-8');
        
        // Assuming these values are stored in a comma-separated format
        $drugNamesArray = explode(',', htmlspecialchars($row['drug_name'], ENT_QUOTES, 'UTF-8'));
        $timesArray = explode(',', htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'));
        $prescriptionsArray = explode(',', htmlspecialchars($row['prescription'], ENT_QUOTES, 'UTF-8'));
        $frequenciesArray = explode(',', htmlspecialchars($row['frequency'], ENT_QUOTES, 'UTF-8'));
        $specialInstructionsArray = explode(',', htmlspecialchars($row['special_instructions'], ENT_QUOTES, 'UTF-8'));

        // Determine the maximum number of prescriptions based on the available arrays
        $maxCount = max(count($drugNamesArray), count($timesArray), count($prescriptionsArray), count($frequenciesArray), count($specialInstructionsArray));

        // Generate the check-up card for each prescription
        $checkupCards .= "
            <div class='col-md-3 mt-2 card-wrapper'>
                <div class='card mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title text-center'>$ownerName</h5>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#checkupModal-$id'>
                            View Details
                        </button>
                    </div>
                </div>
            </div>";

        // Generate the modal for each check-up record
        $checkupCards .= "
        <div class='modal fade' id='checkupModal-$id' tabindex='-1' aria-labelledby='checkupModalLabel-$id' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='checkupModalLabel-$id'>Prescription Details</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <div class='container my-5'>
                            <div class='row cus_inf'>
                                <div class='d-flex'>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <h5 class='text-center'>Happy Vet Animal Clinic and Grooming Center</h5>
                                            <div class='d-flex gap-2 justify-content-center mx-auto'>
                                                <strong><p>Tel.No : 046-409-1254</p></strong>
                                                <strong><p>Cel No : 0923-186-4610</p></strong>
                                            </div>
                                        </div>
                                        <div class='col-md-6 d-flex'>
                                            <label for='owner'>Owner's Name:</label>
                                            <input class='mt-1' type='text' name='owner_name' value='$ownerName' readonly>
                                        </div>
                                        <div class='col-md-6 d-flex'>
                                            <label for='date'>Date:</label>
                                            <input class='mt-1' type='date' name='date' value='$date' readonly>
                                        </div>
                                        <div class='col-md-6 d-flex'>
                                            <label for='pet-name'>Pet's Name:</label>
                                            <input class='mt-1' type='text' name='pet_name' value='$pet_name' readonly>
                                        </div>
                                        <div class='col-md-6 d-flex'>
                                            <label for='age'>Age:</label>
                                            <input class='mt-1' type='number' name='age' value='$age' readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-2 rx'>
                                    <img src='../../../../assets/img/rx.png' alt=''>
                                </div>
                            </div>
                        </div>

                        <div class='form-row'>
                            <div class='col-md-12 table-responsive justify-content-center mx-auto'>
                                <table class='table table-bordered prstion'>
                                    <tbody>
                                        <tr>
                                            <td class='text-center'>Name of Drug</td>
                                            <td class='text-center'>Time</td>
                                            <td class='text-center'>Prescription</td>
                                            <td class='text-center'>Frequency</td>
                                            <td class='text-center'>Special Instructions</td>
                                        </tr>";

        // Loop through the maximum count to display prescription details
        for ($i = 0; $i < $maxCount; $i++) {
            // Initialize variables to hold the values or set them to an empty string
            $drugName = isset($drugNamesArray[$i]) ? htmlspecialchars($drugNamesArray[$i], ENT_QUOTES, 'UTF-8') : '';
            $time = isset($timesArray[$i]) ? htmlspecialchars($timesArray[$i], ENT_QUOTES, 'UTF-8') : '';
            $prescription = isset($prescriptionsArray[$i]) ? htmlspecialchars($prescriptionsArray[$i], ENT_QUOTES, 'UTF-8') : '';
            $frequency = isset($frequenciesArray[$i]) ? htmlspecialchars($frequenciesArray[$i], ENT_QUOTES, 'UTF-8') : '';
            $specialInstruction = isset($specialInstructionsArray[$i]) ? htmlspecialchars($specialInstructionsArray[$i], ENT_QUOTES, 'UTF-8') : '';

            // Only create a row if there is at least one value to display
            if ($drugName || $time || $prescription || $frequency || $specialInstruction) {
                $checkupCards .= "
                                        <tr>
                                            <td><input type='text' class='h-100 dwrm text-center' name='drug_name[]' value='$drugName' readonly></td>
                                            <td><input type='text' class='h-100 dwrm text-center' name='time[]' value='$time' readonly></td>
                                            <td><input type='text' class='h-100 dwrm text-center' name='prescription[]' value='$prescription' readonly></td>
                                            <td><input type='number' class='h-100 dwrm text-center' name='frequency[]' value='$frequency' readonly></td>
                                            <td><input type='text' class='h-100 dwrm text-center' name='special_instructions[]' value='$specialInstruction' readonly></td>
                                        </tr>";
            }
        }

        $checkupCards .= "
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
} else {
    // If no records are found, display a warning message
    $checkupCards .= "<div class='alert alert-warning'>No wellness records found.</div>";
}

// Close the database connection
$conn->close();

// Output the generated checkup cards and modals
echo $checkupCards;
