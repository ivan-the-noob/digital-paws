<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/appointment.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places"></script>

</head>

<?php
session_start();


include '../../../../db.php';

// Check if the user is logged in
if (isset($_SESSION['email']) && isset($_SESSION['profile_picture'])) {
  $email = $_SESSION['email'];
  $profile_picture = $_SESSION['profile_picture'];
} else {
  header("Location: ../../web/api/login.php");
  exit();
}

// Handle POST request for booking an appointment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ownerName = $_POST['ownerName'];
  $contactNum = $_POST['contactNum'];
  $email = $_POST['ownerEmail'];
  $barangay = $_POST['barangayDropdown'];
  $petType = $_POST['petType'];
  $breed = $_POST['breed'];
  $age = $_POST['age'];
  $service = $_POST['service'];
  $payment = $_POST['payment'];
  $appointmentDate = $_POST['appointment_date']; 
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude']; 
  $addInfo = $_POST['add-info']; 

  // Prepare the SQL statement to insert into the appointment table
  $stmt = $conn->prepare("INSERT INTO appointment (owner_name, contact_num, email, barangay, pet_type, breed, age, service, payment, appointment_date, latitude, longitude, add_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  if ($stmt === false) {
      die("Error preparing statement: " . $conn->error);
  }

  // Bind the parameters
  $stmt->bind_param("ssssssissssss", $ownerName, $contactNum, $email, $barangay, $petType, $breed, $age, $service, $payment, $appointmentDate, $latitude, $longitude, $addInfo);

  // Execute the query and check if successful
  if ($stmt->execute()) {
    // Log the appointment booking event in the global_reports table
    $appointmentTime = date("h:i A | m/d/Y"); // Current time of appointment booking
    $message = "$email booked an appointment at $appointmentTime";

    // Prepare the SQL statement to insert into the global_reports table
    $log_sql = "INSERT INTO global_reports (message, cur_time) VALUES (?, NOW())";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bind_param("s", $message);
    $log_stmt->execute();
    $log_stmt->close();

    // Success message
    echo "New appointment booked successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close statement and connection
  $stmt->close();
  $conn->close();
}
?>



<body onload="initAutocomplete()">
<nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
            <a class="navbar-brand d-none d-lg-block" href="#">
                    <img src="assets/img/logo.pngs" alt="Logo" width="30" height="30">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="stroke: black; fill: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav d-flex ">
                        <li class="nav-item">
                            <a class="nav-link" href="../../../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Appointment</a>
                        </li>
                    </ul>
                    <div class="d-flex ml-auto">
                        <?php if ($email): ?>
                            <div class="dropdown second-dropdown">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="../../../../assets/img/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile Image" class="profile">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="/features/users/web/api/dashboard.html">Profile</a></li>
                                    <li><a class="dropdown-item" href="../../../../features/users/function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>


                        <?php else: ?>
                        <a href="../../../features/users/web/api/login.php" class="btn-theme" type="button">Login</a>
                        <?php endif; ?>
                       
                    </div>
        </nav>
    <!--Header End-->

  <!--Appointment Section-->
  <section class="appointment">
    <div class="content py-5 date">
      <div class="col-md-8 col-11 app">
        <div class="appoints">
          <button>Appointment Availability</button>
          <button class="appoint" id="toggleViewBtn">My Appointment</button>
        </div>
        <div class="card card-outline card-primary rounded-0 shadow" id="appointmentSection">
          <div class="card-body">
            <div class="calendar-container">
              <div id="appointmentCalendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="dayModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="info" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title" id="modalLabel">Book Your Desired Schedule</h5>
        <button type="button"  data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="appointmentForm" method="POST" action="appointment.php">
        <div class="sched row">
          <div class="col-md-6">
            <p>Appointment Schedule</p>
            <div id="modalContent" class="col-6"></div>
            <input type="hidden" id="appointment_date" name="appointment_date" value="">
          </div>
         
        </div>
        <div class="line w-100 my-3"></div>
        <div class="row">
          <!-- Left Side: Autocomplete and Map -->
          <div class="col-md-6">
          <h6>Owner Information</h6>
          <div class="form-group">
          <label for="ownerName" class="form-label">Name</label>
                <input type="text" class="form-control" id="ownerName" name="ownerName" placeholder="Ex. Ivan Ablanida" required>
              </div>
              <div class="form-group">
                <label for="contactNum" class="form-label">Contact #</label>
                <input type="tel" class="form-control" id="contactNum" name="contactNum" placeholder="Ex. 09123456879" required>
              </div>
              <div class="form-group">
                  <label for="ownerEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="ownerEmail" name="ownerEmail" 
                        value="<?php echo htmlspecialchars($email); ?>" readonly required>
              </div>
              <h6 class="pet-divide">Pet Information</h6>
              <div class="form-group">
                <label for="petType" class="form-label">Pet Type</label>
                <select class="form-control" id="petType" name="petType" required>
                  <option>Cat</option>
                  <option>Dog</option>
                  <option>Rabbit</option>
                  <option>Reptile</option>
                </select>
              </div>
              <div class="form-group">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" name="breed" placeholder="Husky">
              </div>
              <div class="form-group">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" placeholder="Months" required>
              </div>
              
            </div>
            
          <div class="col-md-6">
              <h6>Address Information</h6>
              <div class="form-group">
              <div class="form-group mt-3" id= "autocomplete-wrapper">
                <input id="autocomplete" placeholder="Can't find your location? Search here." type="text" class="form-control">
              </div>
                <select id="barangayDropdown" class="form-control w-50 mt-2 mb-2" name="barangayDropdown" disabled>
                  <option value="">Select Barangay</option>
                </select>
              </div>
              <div id="modalMap" style="height: 400px;"></div>
              <input type="text" class="form-control mt-2" id="addInfo" name="add-info" placeholder="Street Name, Building, House No." required>
              <input type="hidden" id="latitude" name="latitude">
              <input type="hidden" id="longitude" name="longitude">
             
            </div>
          </div>

          <div class="row">
            <!-- Pet Information -->
            <div class="col-md-6 mt-3">
              
            </div>
            
            <div class="col-md-6 mt-3">
              <h6>Services</h6>
              <?php
require '../../../../db.php';

try {
    $sql = "SELECT service_name, cost, discount, service_type FROM service_list";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $clinic_services = [];
    $home_services = [];

    while ($row = $result->fetch_assoc()) {
        $discounted_cost = $row['cost'] - ($row['cost'] * ($row['discount'] / 100));
        
        $service_data = [
            'service_name' => $row['service_name'],
            'cost' => number_format($row['cost'], 2), 
            'discount' => $row['discount'],
            'discounted_cost' => number_format($discounted_cost, 2),
            'service_type' => $row['service_type']
        ];

        if (strtolower($row['service_type']) === 'clinic') {
            $clinic_services[] = $service_data;
        } elseif (strtolower($row['service_type']) === 'home') {
            $home_services[] = $service_data;
        }
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>

<!-- HTML Select Element -->
<div class="form-group">
    <label for="service" class="form-label">Service</label>
    <select class="form-control" id="service" name="service" required onchange="updatePayment()">
        <!-- Clinic Services -->
        <optgroup label="Clinic Services" class="clinic-services">
            <?php foreach ($clinic_services as $service): ?>
                <option value="<?php echo htmlspecialchars($service['service_name']); ?>" 
                        data-payment="<?php echo htmlspecialchars($service['discounted_cost']); ?>" 
                        data-discount="<?php echo htmlspecialchars($service['discount']); ?>">
                    <?php echo htmlspecialchars($service['service_name']); ?> - 
                    ₱<?php echo htmlspecialchars($service['cost']); ?> - 
                    <?php echo htmlspecialchars($service['discount']); ?>%
                </option>
            <?php endforeach; ?>
        </optgroup>
        <!-- Home Services -->
        <optgroup label="Home Services" class="home-services">
            <?php foreach ($home_services as $service): ?>
                <option value="<?php echo htmlspecialchars($service['service_name']); ?>" 
                        data-payment="<?php echo htmlspecialchars($service['discounted_cost']); ?>" 
                        data-discount="<?php echo htmlspecialchars($service['discount']); ?>">
                    <?php echo htmlspecialchars($service['service_name']); ?> - 
                    ₱<?php echo htmlspecialchars($service['cost']); ?> - 
                    <?php echo htmlspecialchars($service['discount']); ?>%
                </option>
            <?php endforeach; ?>
        </optgroup>
    </select>
</div>


    <div class="form-group mt-2">
        <label for="totalPayment" class="form-label mb-0">Total Payment</label>
        <p id="totalPayment">₱ 0.00</p>
    </div>

    <!-- Hidden input for payment -->
    <input type="hidden" id="payment" name="payment"/>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary book-save">Book Appointment</button>
    </div>
    <script>
    function updatePayment() {
        var serviceSelect = document.getElementById('service');
        var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        var payment = selectedOption.getAttribute('data-payment');
        document.getElementById('totalPayment').textContent = '₱' + payment;
        document.getElementById('payment').value = payment;
    }
</script>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




  </section>
  <!--Appointment Section End-->

    <!--Book-History Section-->
  <section class="booked-history py-5" id="bookedHistorySection" style="display: none;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12 col-24">
          <div class="card card-outline card-primary rounded-0 shadow">
            <div class="card-header rounded-0">
              <h4 class="card-title text-center">Booked History</h4>
            </div>
            <div class="tab-bar">
              <button id="currentBtn">Current Appointment</button>
              <button class="none"> |</button>
              <button id="pastBtn">Past Appointment</button>
            </div>
            <div class="card-body">
              <ul class="list-group" id="historyList">
                <?php 
                require '../../../../db.php';
                $sql = "SELECT * FROM appointment WHERE status IN ('pending', 'waiting', 'on-going') ORDER BY appointment_date DESC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="list-group-item current-appointment">
                      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div>
                            <h5 class="mb-1">Appointment</h5>
                          <p class="mb-1">Service: <?php echo $row['service']; ?></p>
                          <p class="mb-1">Pet: <?php echo $row['pet_type'] . ', ' . $row['age'] . ' Yr Old'; ?></p>
                          <p>Owner: <?php echo $row['owner_name']; ?></p>
                        </div>
                        <div class="mt-3 mt-md-0 text-md-right">
                        <p class="mb-1 status" style="background-color: 
                            <?php 
                                if ($row['status'] == 'pending') {
                                    echo '#007bff';
                                } elseif ($row['status'] == 'waiting') {
                                    echo 'ffc107';
                                } elseif ($row['status'] == 'on-going') {
                                    echo 'g28a745';
                                }
                            ?>;">
                            <?php echo $row['status']; ?>
                        </p>

                          <p class="mb-1">Date: <?php echo $row['appointment_date']; ?></p>
                          <a href="appointment.php?cancel=<?php echo $row['id']; ?>"><button class="btn btn-primary">Cancel</button></a>
                        </div>
                      </div>
                    </li>
                    <?php
                  }
                } else {
                  echo "<p>No appointments found</p>";
                }
                
                $conn->close();
                ?>
               <?php 
                require '../../../../db.php';
                $sql = "SELECT * FROM appointment WHERE status = 'finish'";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="list-group-item past-appointment">
                      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div>
                            <h5 class="mb-1">Appointment</h5>
                          <p class="mb-1">Service: <?php echo $row['service']; ?></p>
                          <p class="mb-1">Pet: <?php echo $row['pet_type'] . ', ' . $row['age'] . ' Yr Old'; ?></p>
                          <p>Owner: <?php echo $row['owner_name']; ?></p>
                        </div>
                        <div class="mt-3 mt-md-0 text-md-right">
                        <p class="mb-1 status" style="background-color: 
                            <?php 
                                if ($row['status'] == 'finish') {
                                    echo 'green';
                                }
                            ?>;">
                            <?php echo $row['status']; ?>
                        </p>

                          <p class="mb-1">Date: <?php echo $row['appointment_date']; ?></p>
                      
                          <a href="appointment.php?cancel=<?php echo $row['id']; ?>"><button class="btn btn-primary">Cancel</button></a>
                        </div>
                      </div>
                    </li>
                    <?php
                  }
                } else {
                  echo "<p>No appointments found</p>";
                }
                
                $conn->close();
                ?>
                
              </ul>
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-3" id="paginationControls">
                  <li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>
                  <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 

  <!--Book-History Modal Section-->


  <!--Chat Bot-->
  <button id="chat-bot-button" onclick="toggleChat()">
    <i class="fa-solid fa-headset"></i>
  </button>

  <div id="chat-interface" class="hidden">
    <div id="chat-header">
      <p>Amazing Day! How may I help you?</p>
      <button onclick="toggleChat()">X</button>
    </div>
    <div id="chat-body">
      <div class="button-bot">
        <button>How to book?</button>
        <button>?</button>
        <button>How to book?</button>
        <button>How to book?</button>
        <button>How to book?</button>
        <button>How to book?</button>
      </div>
    </div>
    <div class="line"></div>
    <div class="admin mt-3">
      <div class="admin-chat">
        <img src="../../../../assets/img/vet logo.jpg" alt="Admin">
        <p>Admin</p>
      </div>
      <p class="text">Hello, I am Chat Bot. Please Ask me a question just by pressing the question buttons.</p>
    </div>
  </div>
</body>

<script>
  function initAutocomplete() {
    var mapCenter = { lat: 14.283634481584178, lng: 120.86458688732908 }; 

    var map = new google.maps.Map(document.getElementById('modalMap'), {
        center: mapCenter,
        zoom: 20,
        mapTypeId: 'roadmap'
    });

    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(14.2680, 120.8400), 
        new google.maps.LatLng(14.2940, 120.8695)
    );

    var input = document.getElementById('autocomplete');

    var autocomplete = new google.maps.places.Autocomplete(input, {
        bounds: defaultBounds,
        strictBounds: false,
        componentRestrictions: {}
    });
    autocomplete.bindTo('bounds', map);

    autocomplete.setFields(['address_component', 'geometry', 'icon', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        draggable: true,
        visible: true
    });

    $('#autocomplete').on('focus', function () {
        var pacContainer = $('.pac-container');
        pacContainer.appendTo('#autocomplete-wrapper');
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();

        if (!place.geometry) {
            console.log("No details available for input: '" + place.name + "'");
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);

        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();

        var city = place.address_components.find(component => component.types.includes('locality'))?.short_name;
        if (city) {
            populateBarangayDropdown(city);
        }
    });

    map.addListener('click', function(event) {
        marker.setPosition(event.latLng);
        marker.setVisible(true);
        infowindow.setContent('<div>New location: <br>' + event.latLng.lat() + ', ' + event.latLng.lng() + '</div>');
        infowindow.open(map, marker);

        document.getElementById('latitude').value = event.latLng.lat();
        document.getElementById('longitude').value = event.latLng.lng();
    });

    marker.addListener('dragend', function(event) {
        infowindow.setContent('<div>Your Exact Location</div>');
        infowindow.open(map, marker);

        document.getElementById('latitude').value = event.latLng.lat();
        document.getElementById('longitude').value = event.latLng.lng();
    });

    function populateBarangayDropdown(city) {
        var barangays = {
            'Trece Martires': {
                'Aguado': { lat: 14.25542581655494, lng: 120.8656522150248},
                'Cabezas': { lat: 14.263709144217062, lng: 120.89555461026328},
                'Cabuco': { lat: 14.279359898149433, lng: 120.84468022563351 },
                'Conchu': { lat: 14.260485726947172, lng: 120.88286485988135 },
                'De Ocampo': { lat: 14.300501942835817, lng: 120.86460081581872 },
                'Gregorio': { lat: 14.288636521925628, lng: 120.87205210047465 },
                'Inocencio': { lat: 14.253491166057374, lng: 120.8777464139661 }, 
                'Lallana': { lat: 14.252491559765417, lng: 120.89643030232541 },
                'Lapidario': { lat: 14.273823626659963, lng: 120.86629069154668 },
                'Luciano': { lat: 14.274976771584905, lng: 120.86903695259147},
                'Osorio': { lat: 14.297669620091915, lng: 120.87694138698265 },
                'Perez': { lat: 14.28327618887629, lng: 120.88951665599205 },
                'San Agustin': { lat: 14.278496301453135, lng: 120.86424085850058 }
            }
        };

        var barangayDropdown = $('#barangayDropdown');
        barangayDropdown.empty();
        barangayDropdown.append('<option value="">Select Barangay</option>');

        if (barangays[city]) {
            for (var barangay in barangays[city]) {
                barangayDropdown.append('<option value="' + barangay + '">' + barangay + '</option>');
            }
            barangayDropdown.prop('disabled', false);
        } else {
            barangayDropdown.prop('disabled', true);
        }

        barangayDropdown.on('change', function() {
            var selectedBarangay = $(this).val();
            if (selectedBarangay && barangays[city][selectedBarangay]) {
                var location = barangays[city][selectedBarangay];
                map.setCenter(location);
                map.setZoom(17);
                marker.setPosition(location);

                document.getElementById('latitude').value = location.lat;
                document.getElementById('longitude').value = location.lng();
            }
        });
    }

    populateBarangayDropdown('Trece Martires');

    function useMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var userLocation = new google.maps.LatLng(lat, lng);

                map.setCenter(userLocation);
                map.setZoom(17);

                marker.setPosition(userLocation);
                marker.setVisible(true);

                infowindow.setContent('<div>Your current location:<br>' + lat + ', ' + lng + '</div>');
                infowindow.open(map, marker);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }, function(error) {
                showError(error);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function validateTime() {
        var timeInput = document.getElementById('appointmentTime');
        var timeValue = timeInput.value;
        var minTime = "09:00";
        var maxTime = "17:00";

        if (timeValue < minTime || timeValue > maxTime) {
            alert("Please select a time between 9:00 AM and 5:00 PM.");
            timeInput.value = "";
        }
    }
}

$('#dayModal').on('shown.bs.modal', function () {
    initAutocomplete();
});

document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    var latitude = document.getElementById('latitude').value;
    var longitude = document.getElementById('longitude').value;

    if (!latitude || !longitude) {
        alert("Please make sure the location is selected on the map.");
        event.preventDefault();
    }
});


    </script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="../../function/script/pagination-history.js"></script>
<script src="../../function/script/calendar.js"></script>
<script src="../../function/script/toggle-appointment.js"></script>
<script src="../../function/script/tab-bar.js"></script>
<script src="../../function/script/service-dropdown.js"></script>
<script src="../../function/script/chatbot-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
