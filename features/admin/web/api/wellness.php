<?php

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8');

    echo "<script>
        window.onload = function() {
            Swal.fire({
                title: 'Success',
                text: '$message',
                icon: 'success',
                confirmButtonText: 'OK',
                html: '$message'
            });
        };
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellness Form | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/wellness.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../function/script/toggle-menu.js"></script>
    <script src="../../function/script/checkup_pagination.js"></script>
    <script src="../../function/script/drop-down.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>



</head>


<body>
    <!--Navigation Links-->
    <div class="navbar flex-column bg-white shadow-sm p-3 collapse d-md-flex" id="navbar">
        <div class="navbar-links">
            <a class="navbar-brand d-none d-md-block logo-container" href="#">
                <img src="../../../../assets/img/logo.png">
            </a>
            <a href="admin.php">
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>
            <a href="#appointment">
                <i class="fa-regular fa-calendar-check"></i>
                <span>User Accounts</span>
            </a>
            <a href="#appointment">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Requests</span>
            </a>
            <a href="#appointment" class="navbar-highlight">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Wellness Form</span>
            </a>


            <div class="maintenance">
                <p class="maintenance-text">Maintenance</p>
                <a href="category-list.php">
                    <i class="fa-solid fa-list"></i>
                    <span>Category List</span>
                </a>
                <a href="service-list.php">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Service List</span>
                </a>
                <a href="admin-user.php">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Admin User List</span>
                </a>
                <a href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>
    <!--Navigation Links End-->
    <div class="content flex-grow-1">
        <div class="header">
            <button class="navbar-toggler d-block d-md-none" type="button" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="stroke: black; fill: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
            <!--Notification and Profile Admin-->
            <div class="profile-admin">
                <div class="dropdown">
                    <button class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../../../assets/img/vet logo.png" class="admin-profile"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    </button>
                    <ul class="dropdown-menu" style="background-color: transparent;">
                        <li><a class="dropdown-item" href="../../../users/web/api/login.html">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Notification and Profile Admin-->
        <div class="app-req">
            <h3>User Accounts</h3>
            <div class="walk-in px-lg-5">
                <div class="mb-3 x d-flex">
                    <div class="search">
                        <div class="search-bars">
                            <i class="fa fa-search"></i> <!-- Updated icon for search -->
                            <input type="text" class="form-control" placeholder="Search..." id="search-input">
                        </div>
                    </div>
                </div>
            </div>


            <div class="button-checkup">
                <button type="button" class="btn checkup-btn" data-bs-toggle="modal" data-bs-target="#checkUpFormModal">
                    Add new Form
                </button>
            </div>

            <div class="checkup-list">
                <?php
                include '../../function/php/wellness_data.php';
                echo $checkupCards;
                ?>
            </div>
            <ul class="pagination justify-content-end mt-3 px-lg-5" id="paginationControls">
                <li class="page-item">
                    <a class="page-link" href="#" data-page="prev">
                        << /a>
                </li>
                <li class="page-item" id="pageNumbers"></li>
                <li class="page-item">
                    <a class="page-link" href="#" data-page="next">></a>
                </li>
            </ul>
        </div>
    </div>
</body>

<div class="modal fade" id="checkUpFormModal" tabindex="-1" aria-labelledby="checkUpFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="checkUpFormModalLabel">Wellness Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../function/php/wellness.php">
                    <div class="form-section">
                        <div class="form-row d-flex gap-1">
                            <div class="form-group col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="ownerName" name="owner_name" required>
                                    <label for="ownerName">Name of Owner:</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="date" name="date" required>
                                    <label for="date">Date:</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row d-flex gap-1">
                            <div class="form-group col-md-7">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="complete-address" name="address"
                                        required>
                                    <label for="complete-address">Complete Address:</label>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="active-number" name="active_number"
                                        required>
                                    <label for="active-number">Active Number:</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row d-flex gap-1">
                            <div class="form-group col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="petName" name="petName" required>
                                    <label for="petName">Pet Name:</label>
                                </div>
                            </div>
                            <div class="form-group col-md-3 p-1 species">
                                <label for="species">Species:</label><br>
                                <div class="specie d-flex">
                                    <div class="mx-2">
                                        <input type="radio" id="canine" name="species" value="Canine" required>
                                        <label for="canine">Canine</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="feline" name="species" value="Feline" required>
                                        <label for="feline">Feline</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="color" name="petColor" required>
                                    <label for="color">Color:</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-flex gap-1">
                            <div class="form-group col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="pet-birthdate" name="pet_birthdate"
                                        required>
                                    <label for="pet-birthdate">Pet Birthdate:</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row  d-flex gap-1">
                            <div class="form-group col-md-3 p-1 species">
                                <label for="gender">Sex:</label><br>
                                <div class="specie d-flex">
                                    <div class="mx-2">
                                        <input type="radio" id="male" name="gender" value="male" required>
                                        <label for="male">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="female" name="gender" value="female" required>
                                        <label for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="breed" name="breed" required>
                                    <label for="breed">Breed:</label>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="diet" name="diet" required>
                                    <label for="diet">Diet:</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-8 table-responsive justify-content-center mx-auto">
                                <table class="table table-bordered deworming">
                                    <thead>
                                        <tr>
                                            <th colspan="5" class="text-center">Deworming</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date Given</td>
                                            <td>Weight</td>
                                            <td>Treatment</td>
                                            <td>Observation</td>
                                            <td>Follow up</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_dwrm[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_dwrm[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_dwrm[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_dwrm[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_dwrm[]"
                                                    id="follow_up"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-8 table-responsive justify-content-center mx-auto">
                                <table class="table table-bordered vac">
                                    <thead>
                                        <tr>
                                            <th colspan="5" class="text-center">Vaccination</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date Given</td>
                                            <td>Weight</td>
                                            <td>Treatment</td>
                                            <td>Observation</td>
                                            <td>Follow up</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="h-100 dwrm" name="date_given_vac[]"
                                                    id="date_given"></td>
                                            <td><input type="text" class="h-100 dwrm" name="weight_vac[]" id="weight">
                                            </td>
                                            <td><input type="text" class="h-100 dwrm" name="treatment_vac[]"
                                                    id="treatment"></td>
                                            <td><input type="text" class="h-100 dwrm" name="observation_vac[]"
                                                    id="observation"></td>
                                            <td><input type="text" class="h-100 dwrm" name="follow_up_vac[]"
                                                    id="follow_up"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>




            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
</form>


<script>
    $(document).ready(function() {
        $('#search-input').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();

            $('.card-body').each(function() {
                let ownerName = $(this).find('#ownerName').text().toLowerCase();
                if (ownerName.includes(searchTerm)) {
                    $(this).closest('.col-md-3').show();
                } else {
                    $(this).closest('.col-md-3').hide();
                }
            });
        });
    });
</script>





</html>