<?php

session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../users/web/api/login.php");
    exit();
}

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
    <link rel="stylesheet" href="../../css/prescription.css">
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
                <img src="../../../../assets/img/logo.png" alt="Logo">
            </a>
            <a href="admin.php">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="users.php">
                <i class="fa-solid fa-users"></i>
                <span>Users</span>
            </a>
            <a href="app-req.php">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Booking Request</span>
            </a>

            <a href="check-up.php">
                <i class="fa-solid fa-file-alt"></i>
                <span>Check Up Form</span>
            </a>
            <a href="wellness.php">
                <i class="fa-solid fa-file-alt"></i>
                <span>Wellness Form</span>
            </a>
            <a href="prescription.php" class="navbar-highlight">
                <i class="fa-solid fa-file-prescription"></i>
                <span>Prescription</span>
            </a>

            <div class="maintenance">
                <p class="maintenance-text">Maintenance</p>
                <a href="service-list.php">
                    <i class="fa-solid fa-list"></i>
                    <span>Service List</span>
                </a>
                <a href="product.php">
                    <i class="fa-solid fa-box"></i>
                    <span>Product</span>
                </a>
                <a href="admin-user.php">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Admin User List</span>
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
                        <img src="../../../../assets/img/vet logo.png"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../../users/web/api/logout.php">Logout</a></li>
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
                    Add new
                </button>
            </div>

            <div class="checkup-list">
                <?php
                include '../../function/php/prescription_data.php';

                ?>
            </div>
            <ul class="pagination justify-content-end mt-3 px-lg-5" id="paginationControls">
                <li class="page-item">
                    <a class="page-link" href="#" data-page="prev">
                        < </a>
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
                <form method="POST" action="../../function/php/prescriptions.php">
                    <div class="container my-5">
                        <div class="row cus_inf">
                            <div class="d-flex">
                                <!--<div class="col-md-3 vet-logo">
                                    <img src="../../../../assets/img/vet logo.png" alt="">
                                </div> !-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-center">Happy Vet Animal Clinic and Grooming Center</h5>
                                        <div class="d-flex gap-2 justify-content-center mx-auto">
                                            <strong>
                                                <p>Tel.No : 046-409-1254</p>
                                            </strong>
                                            <strong>
                                                <p>Cel No : 0923-186-4610</p>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <label for="owner">Owner's Name:</label>
                                        <input class="mt-1" type="text" placeholder="Input Name:" name="owner_name">
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <label for="date">Date:</label>
                                        <input class="mt-1" type="date" placeholder="Input Date:" name="date">
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <label for="pet-name">Pet's Name:</label>
                                        <input class="mt-1" type="text" placeholder="Input Pet Name:" name="pet_name">
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <label for="pet-name">Age:</label>
                                        <input class="mt-1" type="number" placeholder="Input Age:" name="age">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 rx">
                                <img src="../../../../assets/img/rx.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 table-responsive justify-content-center mx-auto">
                            <table class="table table-bordered prstion">
                                <tbody>
                                    <tr>
                                        <td class="text-center">Name of
                                            Drug</td>
                                        <td class="text-center">Time</td>
                                        <td class="text-center">Prescription</td>
                                        <td class="text-center">Frequency</td>
                                        <td class="text-center">Special Instructions</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="h-100 dwrm" name="drug_name[]" id="drug_name">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="time[]" id="time" step="60">
                                        </td>

                                        <td><input type="text" class="h-100 dwrm" name="prescription[]"
                                                id="prescription">
                                        </td>
                                        <td><input type="number" class="h-100 dwrm" name="frequency[]" id="frequency">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="special_instructions[]"
                                                id="special_instructions"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="h-100 dwrm" name="drug_name[]" id="drug_name">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="time[]" id="time" step="60">
                                        </td>

                                        <td><input type="text" class="h-100 dwrm" name="prescription[]"
                                                id="prescription">
                                        </td>
                                        <td><input type="number" class="h-100 dwrm" name="frequency[]" id="frequency">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="special_instructions[]"
                                                id="special_instructions"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="h-100 dwrm" name="drug_name[]" id="drug_name">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="time[]" id="time" step="60">
                                        </td>

                                        <td><input type="text" class="h-100 dwrm" name="prescription[]"
                                                id="prescription">
                                        </td>
                                        <td><input type="number" class="h-100 dwrm" name="frequency[]" id="frequency">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="special_instructions[]"
                                                id="special_instructions"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="h-100 dwrm" name="drug_name[]" id="drug_name">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="time[]" id="time" step="60">
                                        </td>

                                        <td><input type="text" class="h-100 dwrm" name="prescription[]"
                                                id="prescription">
                                        </td>
                                        <td><input type="number" class="h-100 dwrm" name="frequency[]" id="frequency">
                                        </td>
                                        <td><input type="text" class="h-100 dwrm" name="special_instructions[]"
                                                id="special_instructions"></td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class=" modal-footer">
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
