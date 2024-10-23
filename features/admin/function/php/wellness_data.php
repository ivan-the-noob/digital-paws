<?php
include '../../../../db.php';

$checkupCards = '';

$sql = "SELECT * FROM wellness";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each database row
    while ($row = $result->fetch_assoc()) {
        // Sanitize the values for safety
        $ownerName = htmlspecialchars($row['owner_name'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8');
        $activeNumber = htmlspecialchars($row['active_number'], ENT_QUOTES, 'UTF-8');
        $petName = htmlspecialchars($row['pet_name'], ENT_QUOTES, 'UTF-8');
        $petBirthdate = htmlspecialchars($row['pet_birthdate'], ENT_QUOTES, 'UTF-8');
        $breed = htmlspecialchars($row['breed'], ENT_QUOTES, 'UTF-8');
        $diet = htmlspecialchars($row['diet'], ENT_QUOTES, 'UTF-8');
        $species = htmlspecialchars($row['species'], ENT_QUOTES, 'UTF-8');
        $color = htmlspecialchars($row['color'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8');
        $date_given_dwrm = htmlspecialchars($row['date_given_dwrm'], ENT_QUOTES, 'UTF-8');
        $weight_dwrm = htmlspecialchars($row['weight_dwrm'], ENT_QUOTES, 'UTF-8');
        $treatment_dwrm = htmlspecialchars($row['treatment_dwrm'], ENT_QUOTES, 'UTF-8');
        $observation_dwrm = htmlspecialchars($row['observation_dwrm'], ENT_QUOTES, 'UTF-8');
        $follow_up_dwrm = htmlspecialchars($row['follow_up_dwrm'], ENT_QUOTES, 'UTF-8');

        $date_given_vac = htmlspecialchars($row['date_given_vac'], ENT_QUOTES, 'UTF-8');
        $weight_vac = htmlspecialchars($row['weight_vac'], ENT_QUOTES, 'UTF-8');
        $treatment_vac = htmlspecialchars($row['treatment_vac'], ENT_QUOTES, 'UTF-8');
        $observation_vac = htmlspecialchars($row['observation_vac'], ENT_QUOTES, 'UTF-8');
        $follow_up_vac = htmlspecialchars($row['follow_up_vac'], ENT_QUOTES, 'UTF-8');

        // Assuming these values are stored in a comma-separated format and need to be split
        $dateGivenArray = explode(',', $date_given_dwrm);
        $weightArray = explode(',', $weight_dwrm);
        $treatmentArray = explode(',', $treatment_dwrm);
        $observationArray = explode(',', $observation_dwrm);
        $followUpArray = explode(',', $follow_up_dwrm);

        $dateGivenVacArray = explode(',', $date_given_vac);
        $weightVacArray = explode(',', $weight_vac);
        $treatmentVacArray = explode(',', $treatment_vac);
        $observationVacArray = explode(',', $observation_vac);
        $followUpVacArray = explode(',', $follow_up_vac);

        // Count the rows for loop iteration based on the size of one of the arrays
        $rowCount = count($dateGivenArray);
        $rowCountVac = count($dateGivenVacArray);

        // Card for each check-up record
        $checkupCards .= "
            <div class='col-md-3 mt-2 card-wrapper'>
                <div class='card mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title text-center'><span id='ownerName'>$ownerName</span></h5>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#checkupModal-$id'>
                            View Details
                        </button>
                    </div>
                </div>
            </div>";

        // Modal for each check-up record
        $checkupCards .= "
        <div class='modal fade' id='checkupModal-$id' tabindex='-1' aria-labelledby='checkupModalLabel-$id' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='checkupModalLabel-$id'>Check-Up Details</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <div class='form-section'>
                            <div class='form-row d-flex'>
                                <div class='form-group col-md-8'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='ownerName' name='owner_name' value='$ownerName' required readonly>
                                        <label for='ownerName'>Name of Owner:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-4'>
                                    <div class='form-floating'>
                                        <input type='hidden' name='date' value='" . (isset($date) ? date('Y-m-d', strtotime($date)) : '') . "'>
                                        <input type='text' class='form-control' id='formatted-checkup-date' value='" . (isset($date) ? date('F j, Y', strtotime($date)) : '') . "' readonly>
                                        <label for='formatted-checkup-date'>Date:</label>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row d-flex'>
                                <div class='form-group col-md-7'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='complete-address' name='address' value='$address' readonly>
                                        <label for='complete-address'>Complete Address:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-5'>
                                    <div class='form-floating'>
                                        <input type='number' class='form-control' id='active-number' name='active_number' value='$activeNumber' readonly>
                                        <label for='active-number'>Active Number:</label>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row d-flex'>
                                <div class='form-group col-md-6'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='petName' name='petName' value='$petName' readonly>
                                        <label for='petName'>Pet Name:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-3'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='species' name='species' value='" . (isset($species) ? htmlspecialchars($species) : 'Not specified') . "' readonly>
                                        <label for='species'>Species:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-3'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='color' name='color' value='$color' readonly>
                                        <label for='color'>Color:</label>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group col-md-4'>
                                <div class='form-floating'>
                                    <input type='hidden' name='pet_birthdate' value='" . date('Y-m-d', strtotime($petBirthdate)) . "'>
                                    <input type='text' class='form-control' id='formatted-birthdate' value='" . date('F j, Y', strtotime($petBirthdate)) . "' readonly>
                                    <label for='formatted-birthdate'>Birthdate:</label>
                                </div>
                            </div>
                            <div class='form-row d-flex'>
                                <div class='form-group col-md-3'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='sex' name='sex' value='$gender' readonly>
                                        <label for='sex'>Sex:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-6'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='breed' name='breed' value='$breed' readonly>
                                        <label for='breed'>Breed:</label>
                                    </div>
                                </div>
                                <div class='form-group col-md-3'>
                                    <div class='form-floating'>
                                        <input type='text' class='form-control' id='diet' name='diet' value='$diet' readonly>
                                        <label for='diet'>Diet:</label>
                                    </div>
                                </div>
                            </div>
                        <div class='form-section'>
                            <div class='container mt-4'>
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th colspan='5' class='text-center'>Deworming</th>
                                        </tr>
                                        <tr>
                                            <th>Date Given</th>
                                            <th>Weight</th>
                                            <th>Treatment</th>
                                            <th>Observation</th>
                                            <th>Follow Up</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

        if ($rowCount > 0) {
            for ($i = 0; $i < $rowCount; $i++) {
                $dateGiven = isset($dateGivenArray[$i]) ? $dateGivenArray[$i] : '';
                $weight = isset($weightArray[$i]) ? $weightArray[$i] : '';
                $treatment = isset($treatmentArray[$i]) ? $treatmentArray[$i] : '';
                $observation = isset($observationArray[$i]) ? $observationArray[$i] : '';
                $followUp = isset($followUpArray[$i]) ? $followUpArray[$i] : '';

                $checkupCards .= "
                <tr>
                    <td>$dateGiven</td>
                    <td>$weight</td>
                    <td>$treatment</td>
                    <td>$observation</td>
                    <td>$followUp</td>
                </tr>";
            }
        } else {
            $checkupCards .= "
            <tr>
                <td colspan='5' class='text-center'>No records found</td>
            </tr>";
        }

        $checkupCards .= "
                                    </tbody>
                                </table>
                            </div>

                            <!-- Vaccination Table -->
                            <div class='container mt-4'>
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th colspan='5' class='text-center'>Vaccination</th>
                                        </tr>
                                        <tr>
                                            <th>Date Given</th>
                                            <th>Weight</th>
                                            <th>Treatment</th>
                                            <th>Observation</th>
                                            <th>Follow Up</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

        if ($rowCountVac > 0) {
            for ($i = 0; $i < $rowCountVac; $i++) {
                $dateGivenVac = isset($dateGivenVacArray[$i]) ? $dateGivenVacArray[$i] : '';
                $weightVac = isset($weightVacArray[$i]) ? $weightVacArray[$i] : '';
                $treatmentVac = isset($treatmentVacArray[$i]) ? $treatmentVacArray[$i] : '';
                $observationVac = isset($observationVacArray[$i]) ? $observationVacArray[$i] : '';
                $followUpVac = isset($followUpVacArray[$i]) ? $followUpVacArray[$i] : '';

                $checkupCards .= "
                <tr>
                    <td>$dateGivenVac</td>
                    <td>$weightVac</td>
                    <td>$treatmentVac</td>
                    <td>$observationVac</td>
                    <td>$followUpVac</td>
                </tr>";
            }
        } else {
            $checkupCards .= "
            <tr>
                <td colspan='5' class='text-center'>No records found</td>
            </tr>";
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
    $checkupCards .= "<div class='alert alert-warning'>No wellness records found.</div>";
}
$conn->close();
echo $checkupCards;