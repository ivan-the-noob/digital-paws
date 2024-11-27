<?php

session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../users/web/api/login.php");
    exit();
}
$email = $_SESSION['email'];

if (isset($_GET['action']) && $_GET['action'] === 'getPayments') {
    header('Content-Type: application/json');

    include '../../../../db.php';

    $currentYear = date('Y');
    $currentMonth = date('n'); // 1 for January, 12 for December

    $lastMonth = $currentMonth - 1;
    $lastYear = $currentYear;

    if ($lastMonth < 1) {
        $lastMonth = 12;
        $lastYear -= 1;
    }

    // SQL query to fetch payment data from both `appointment` and `manual_input`
    $sql = "
        SELECT MONTH(created_at) as month, YEAR(created_at) as year, SUM(payment) as total
        FROM (
            -- Appointment sales where status is 'finish'
            SELECT created_at, payment FROM appointment WHERE status = 'finish'
            UNION ALL
            -- Manual sales from the manual_input table
            SELECT created_at, sales_amount as payment FROM manual_input
        ) AS all_sales
        WHERE YEAR(created_at) = $currentYear  -- Filter for the current year
        GROUP BY YEAR(created_at), MONTH(created_at)
        ORDER BY YEAR(created_at), MONTH(created_at)";

    $result = $conn->query($sql);

    // Initialize the payments array for current and last month
    $payments = [
        'currentMonth' => array_fill(0, 12, 0),
        'lastMonth' => array_fill(0, 12, 0)
    ];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $monthIndex = intval($row['month']) - 1;
            if ($row['year'] == $currentYear && $row['month'] == $currentMonth) {
                $payments['currentMonth'][$monthIndex] = floatval($row['total']);
            } elseif ($row['year'] == $lastYear && $row['month'] == $lastMonth) {
                $payments['lastMonth'][$monthIndex] = floatval($row['total']);
            }
        }
    }

    $conn->close();

    echo json_encode($payments);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/index.css">
</head>

<body>
    <!--Navigation Links-->
    <div class="navbar flex-column bg-white shadow-sm p-3 collapse d-md-flex" id="navbar">
        <div class="navbar-links">
            <a class="navbar-brand d-none d-md-block logo-container" href="#">
                <img src="../../../../assets/img/logo.png" alt="Logo">
            </a>
            <a href="#dashboard" class="navbar-highlight">
                <i class="fa-solid fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="users.php">
                <i class="fa-solid fa-users"></i>
                <span>Users</span>
            </a>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center" id="checkoutDropdowns" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="ms-2">Booking</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="checkoutDropdowns">
                    <li><a class="dropdown-item" href="app-req.php"><i class="fa-solid fa-calendar-check"></i> <span>Pending Bookings</span></a></li>
                    <li><a class="dropdown-item" href="app-waiting.php"><i class="fa-solid fa-calendar-check"></i> <span>Waiting Bookings</span></a></li>
                    <li><a class="dropdown-item" href="app-ongoing.php"><i class="fa-solid fa-calendar-check"></i> <span>On Going Bookings</span></a></li>
                    <li><a class="dropdown-item" href="app-finish.php"><i class="fa-solid fa-calendar-check"></i> <span>Finished Bookings</span></a></li>
                    <li><a class="dropdown-item" href="app-cancel.php"><i class="fa-solid fa-calendar-check"></i> <span>Cancelled Bookings</span></a></li>
                   
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center dropdown-toggle" id="checkoutDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="ms-2">Checkout</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="checkoutDropdown">
                    <li><a class="dropdown-item" href="pending_checkout.php"><i class="fa-solid fa-calendar-check"></i> <span>Pending CheckOut</span></a></li>
                    <li><a class="dropdown-item" href="to-ship_checkout.php"><i class="fa-solid fa-calendar-check"></i> <span>To-Ship CheckOut</span></a></li>
                    <li><a class="dropdown-item" href="to-receive.php"><i class="fa-solid fa-calendar-check"></i> <span>To-Receive CheckOut</span></a></li>
                    <li><a class="dropdown-item" href="delivered_checkout.php"><i class="fa-solid fa-calendar-check"></i> <span>Delivered</span></a></li>
                    <li><a class="dropdown-item" href="decline.php"><i class="fa-solid fa-calendar-check"></i> <span>Declined</span></a></li>
                </ul>
            </div> 

           

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
        <!--Notification and Profile Admin End-->
        <!--Pos Card with graphs-->
        <div class="dashboard">
            <div class="d-flex justify-content-between">
                <h3>Dashboard</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salesModal">
                    + Sales
                </button>
            </div>
            <div class="row card-box">
                <div class="col-12 col-md-6 col-lg-3 cc">
                    <div class="card">
                        <div class="cards">
                            <div class="card-text">
                                <p>Total Users</p>
                                <h5>125</h5>
                            </div>
                            <div class="logo">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <div class="trend card-up"><i class="fa-solid fa-arrow-trend-up"> 8.5 % </i> Up from yesterday
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 cc">
                    <div class="card">
                        <div class="cards">
                            <div class="card-text">
                                <p>Total Booked</p>
                                <h5>20</h5>
                            </div>
                            <div class="logo">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="trend card-up"><i class="fa-solid fa-arrow-trend-up"> 1.3 % </i> Up from yesterday
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 cc">
                    <div class="card">
                        <div class="cards">
                            <div class="card-text">
                                <p>Total Sales</p>
                                <h5>₱40,689</h5>
                            </div>
                            <div class="logo">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="trend card-down"><i class="fa-solid fa-arrow-trend-down"> 4.3 % </i> Down from
                            yesterday</div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 cc">
                    <div class="card">
                        <div class="cards">
                            <div class="card-text">
                                <p>Total Pending</p>
                                <h5>10</h5>
                            </div>
                            <div class="logo">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                        </div>
                        <div class="trend card-up"><i class="fa-solid fa-arrow-trend-up"> 8.5 % </i> Up from yesterday
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="global-container">
                <?php 
require '../../../../db.php';

$sql = "SELECT * FROM global_reports ORDER BY cur_time DESC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the reports
    while ($row = $result->fetch_assoc()) {
        $message = $row['message'];
        $time = $row['cur_time']; // Assuming current_time is a TIMESTAMP column
        
        
        // Display the message and time
        echo "<div class='report'>";
        echo "<p>$message<span class='report-time'> $time</span></p><hr>";
        echo "</div>";
    }
} else {
    echo "<p>No reports available.</p>";
}

$conn->close();
?>

   
</div>
            </div>
        </div>

        <div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Add Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="salesForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="salesAmount" class="form-label">Sales Amount:</label>
                        <input type="number" step="0.01" class="form-control" id="salesAmount" name="salesAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="salesMonth" class="form-label">Month:</label>
                        <select class="form-select" id="salesMonth" name="salesMonth" required>
                            <option value="" disabled selected>Select Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="salesYear" class="form-label">Year:</label>
                        <input type="number" class="form-control" id="salesYear" name="salesYear" 
                               min="2000" max="2100" value="<?= date('Y') ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("salesForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const salesAmount = document.getElementById("salesAmount").value;
    const salesMonth = document.getElementById("salesMonth").value;
    const salesYear = document.getElementById("salesYear").value;

    const form = new FormData();
    form.append("action", "addSales");
    form.append("salesAmount", salesAmount);
    form.append("salesMonth", salesMonth);
    form.append("salesYear", salesYear);

    fetch("../../function/php/add_sales.php", {
        method: "POST",
        body: form,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Sales added successfully!");
            location.reload();
        } else {
            alert("Failed to add sales: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>

        <!--Pos Card with graphs End-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../function/script/month-chart.js"></script>
        <script src="../../function/script/toggle-menu.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>