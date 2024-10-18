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
    <title>Check Up Form | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/check-up.css">
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
                <span>Check Up Form</span>
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
                        <img src="../../../../assets/img/vet logo.png" class="admin-profile" style="width: 40px; height: 40px; object-fit: cover;">
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
                    include '../../function/php/checkup_data.php';
                    echo $checkupCards;
                ?>
            </div>
            <ul class="pagination justify-content-end mt-3 px-lg-5" id="paginationControls">
                <li class="page-item">
                    <a class="page-link" href="#" data-page="prev"><</a>
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h5 class="modal-title" id="checkUpFormModalLabel">Check-up Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="../../function/php/check_up.php">
        <div class="form-section">
            <div class="form-row d-flex">
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
            
            <div class="form-row d-flex">
                <div class="form-group col-md-7">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="complete-address" name="address" required>
                        <label for="complete-address">Complete Address:</label>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="active-number" name="active_number" required>
                        <label for="active-number">Active Number:</label>
                    </div>
                </div>
            </div>

            <div class="form-row d-flex">
                <div class="form-group col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="petName" name="petName" required>
                        <label for="petName">Pet Name:</label>
                    </div>
                </div>
                <div class="form-group col-md-3 p-2 species d-flex">
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
            <div class="form-row d-flex">
                <div class="form-group col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="pet-birthdate" name="pet_birthdate" required>
                        <label for="pet-birthdate">Pet Birthdate:</label>
                    </div>
                </div>
            </div>

            <div class="form-row d-flex">
                <div class="form-group col-md-3 p-2 species d-flex">
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
                <div class="col-md-14">
                    <table class="table table-bordered physical">
                        <thead>
                            <tr>
                                <th colspan="2">Physical Examination Weight</th>
                                <th colspan="2">Chief Complaint</th>
                                <th colspan="2">Treatment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bcs">BCS: 
                                    <input type="radio" name="bcs" value="1" required> 1 
                                    <input type="radio" name="bcs" value="2" required> 2 
                                    <input type="radio" name="bcs" value="3" required> 3 
                                    <input type="radio" name="bcs" value="4" required> 4 
                                    <input type="radio" name="bcs" value="5" required> 5
                                </td>
                                <td class="stool">Stool: 
                                    <input type="radio" name="stool" value="firm" required> Firm
                                    <input type="radio" name="stool" value="watery_wet" required> Watery/Wet
                                </td>
                                    <td colspan="2" rowspan="8">
                                        <textarea type="text" class="form-control h-100 input-col" name="chief_complaint" rows="3" style="border: none;" required></textarea>
                                    </td>
                                    <td colspan="2" rowspan="8">
                                        <textarea class="form-control h-100" name="treatment" rows="3" style="border: none;" required></textarea>
                                    </td>

                            </tr>
                            <tr>

                                <td>
                                    <label for="vomiting">Vomiting: </label>
                                    <input type="radio" name="vomiting" value="yes" required> Yes 
                                    <input type="radio" name="vomiting" value="no" required> No
                                </td>
                                <td>Ticks/Fleas: 
                                    <input type="radio" name="ticks_fleas" value="present" required> Present
                                    <input type="radio" name="ticks_fleas" value="none" required> None
                                </td>
                               
                            </tr>
                            <tr>
                                <td colspan="2" class="title" style="background-color: #808080; color: #fff;">
                                    Laboratory
                                </td>
                            </tr>
                            <tr>
                                <td class="title">
                                    Fecalysis:
                                </td>
                                <td class="title">
                                <label for="leptop" class="radio-label">Lepto: </label>
                                    <input type="radio" name="lepto" value="+" required>(+)
                                    <input type="radio" name="lepto" value="-" required> (-)
                                </td>
                            </tr>
                            <tr>
                                <td class="title">
                                    Ear swab:
                                </td>
                                <td class="title">
                                <label for="ear-swab" class="radio-label">CHW </label>
                                    <input type="radio" name="chw" value="+" required>(+)
                                    <input type="radio" name="chw" value="-" required> (-)
                                </td>
                            </tr>
                            <tr>
                                <td class="title">
                                    Skin Scrape:
                                </td>
                                <td class="title">
                                <label for="skin-scrape" class="radio-label">CPV </label>
                                    <input type="radio" name="cpv" value="+" required>(+)
                                    <input type="radio" name="cpv" value="-" required> (-)
                                </td>
                            </tr>
                            <tr>
                                <td class="title">
                                    Vaginal Smear: 
                                </td>
                                <td class="title">
                                <label for="vaginal-smear" class="radio-label">CDV </label>
                                    <input type="radio" name="cdv" value="+" required>(+)
                                    <input type="radio" name="cdv" value="-" required> (-)
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="title">
                                <label for="CBC" class="radio-label">CBC:</label>
                                    <input type="radio" name="cbc" value="+" required>Proceed
                                    <input type="radio" name="cbc" value="-" required> Denied
                                </td>
                                <td class="title">
                                    ANA/BAB/EHR:
                                </td>
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