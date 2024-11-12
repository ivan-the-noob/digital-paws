<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/my-order.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmgygVeipMUsrtGeZPZ9UzXRmcVdheIqw&libraries=places">
    </script>

</head>

<?php
session_start();
$email = isset($_SESSION['email']);
include '../../../../db.php';
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand d-none d-lg-block" href="#">
            <img src="assets/img/logo.pngs" alt="Logo" width="30" height="30">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                style="stroke: black; fill: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                </path>
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
                        <button class="btn" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="../../../../assets/img/customer.jfif" alt="Profile Image" class="profile">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="/features/users/web/api/dashboard.html">Profile</a></li>
                            <li><a class="dropdown-item"
                                    href="../../../../features/users/function/authentication/logout.php">Logout</a></li>
                        </ul>
                    </div>


                <?php else: ?>
                    <a href="../../../features/users/web/api/login.php" class="btn-theme" type="button">Login</a>
                <?php endif; ?>

            </div>
</nav>

<body>
    <div class="container mt-4">
        <div class="row">
            <h5>My Orders</h5>

            <div class="order-button d-flex gap-1 mt-4">
                <button class="button-highlight">Orders</button>
                <button>To Ship</button>
                <button>To Receive</button>
                <button>Received Orders</button>
                <button>Cancelled Orders</button>
            </div>
        </div>
    </div>
</body>
<!--Header End-->


<script src=" https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js">
</script>
<script src="../../function/script/chatbot-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>

</html>