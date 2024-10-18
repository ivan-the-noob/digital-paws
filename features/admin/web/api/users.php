

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/app-req.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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
            <a href="#appointment" class="navbar-highlight">
                <i class="fa-regular fa-calendar-check"></i>
                <span>User Accounts</span>
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
                        <i class="fa fa-magnifying-glass"></i>
                        <input type="text" class="form-control" placeholder="Search..." id="search-input">
                    </div>
                </div>
                  
                </div>
            </div>
            <div class="table-wrapper px-lg-5">
                <table class="table table-hover table-remove-borders">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Button</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                        
                        <?php 
                        include '../../../../db.php';
                        include '../../function/php/users.php'
                          ?>
                                     
                    </tbody>
                </table>
            <!--Appointment Request Table End-->

            
          
                
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

<script>
$(document).ready(function() {
    $('#detailsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ownerName = button.data('owner');
        var contactNum = button.data('contact');
        var email = button.data('email');
        var barangay = button.data('barangay');
        var petType = button.data('pettype');
        var breed = button.data('breed');
        var age = button.data('age');
        var service = button.data('service'); // Ensure this line is present
        var totalPayment = button.data('totalpayment');
        var appointmentTime = button.data('appointmenttime');
        var appointmentDate = button.data('appointmentdate');
        var lat = parseFloat(button.data('lat')); // Latitude
        var lng = parseFloat(button.data('lng')); // Longitude

        var modal = $(this);
        modal.find('#modalOwnerName').text(ownerName);
        modal.find('#modalContactNum').text(contactNum);
        modal.find('#modalEmail').text(email);
        modal.find('#modalBarangay').text(barangay);
        modal.find('#modalPetType').text(petType);
        modal.find('#modalBreed').text(breed);
        modal.find('#modalAge').text(age);
        modal.find('#modalService').text(service); // Ensure this line is present
        modal.find('#modalTotalPayment').text(totalPayment);
        modal.find('#modalAppointmentTime').text(appointmentTime);
        modal.find('#modalAppointmentDate').text(appointmentDate);

        // Initialize and display Google Map
        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: 20,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('modalMap'), mapOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            title: ownerName
        });
    });
});


document.getElementById('search-input').addEventListener('input', function() {
    const searchTerm = this.value;

    const xhr = new XMLHttpRequest();

    xhr.open('GET', '../../function/php/search/search_users.php?query=' + encodeURIComponent(searchTerm), true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);

            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            results.forEach((user, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        <form action='../../function/php/delete_user.php' method='POST'>
                            <input type='hidden' name='user_id' value='${user.id}' />
                            <input type='submit' value='Delete' class='btn btn-danger' />
                        </form>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
    };

    // Send the request
    xhr.send();
});

</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="../../function/script/toggle-menu.js"></script>
<script src="../../function/script/pagination.js"></script>
<script src="../../function/script/drop-down.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</html>