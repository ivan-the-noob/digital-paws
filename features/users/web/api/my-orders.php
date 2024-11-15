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
        <button class="button-highlight" onclick="showSection('orders')">Orders</button>
        <button onclick="showSection('to-ship')">To Ship</button>
        <button onclick="showSection('to-receive')">To Receive</button>
        <button onclick="showSection('received-orders')">Received Orders</button>
        <button onclick="showSection('cancelled-orders')">Cancelled Orders</button>
      </div>
    </div>
    <?php
    // Fetch orders with 'orders' status
    $sql = "SELECT * FROM checkout WHERE status = 'orders'";
    $result = $conn->query($sql);

    $orders = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    // Fetch orders with 'to-ship' status
    $sql_to_ship = "SELECT * FROM checkout WHERE status = 'to-ship'";
    $result_to_ship = $conn->query($sql_to_ship);

    $to_ship_orders = [];
    if ($result_to_ship->num_rows > 0) {
        while ($row = $result_to_ship->fetch_assoc()) {
            $to_ship_orders[] = $row;
        }
    }

    // Fetch orders with 'to-receive' status
    $sql_to_receive = "SELECT * FROM checkout WHERE status = 'to-receive'";
    $result_to_receive = $conn->query($sql_to_receive);

    $to_receive_orders = [];
    if ($result_to_receive->num_rows > 0) {
        while ($row = $result_to_receive->fetch_assoc()) {
            $to_receive_orders[] = $row;
        }
    }

    // Fetch orders with 'completed' status
    $sql_completed = "SELECT * FROM checkout WHERE status = 'received-order'";
    $result_completed = $conn->query($sql_completed);

    $completed_orders = [];
    if ($result_completed->num_rows > 0) {
        while ($row = $result_completed->fetch_assoc()) {
            $completed_orders[] = $row;
        }
    }

    // Fetch orders with 'cancelled' status
    $sql_cancelled = "SELECT * FROM checkout WHERE status = 'cancel'";
    $result_cancelled = $conn->query($sql_cancelled);

    $cancelled_orders = [];
    if ($result_cancelled->num_rows > 0) {
        while ($row = $result_cancelled->fetch_assoc()) {
            $cancelled_orders[] = $row;
        }
    }
?>

<!-- Displaying Orders -->
<div class="orders">
    <?php foreach ($orders as $order): ?>
        <div class="card p-3 mt-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../../../../assets/img/product/<?php echo htmlspecialchars($order['product_img']); ?>" alt="Product Image" class="img-fluid" style="border-radius: 10px;" />
                </div>
                <div class="col-md-7">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h5>
                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                </div>
                <div class="col-md-3 text-end">
                    <div class="d-flex gap-1">
                        <p class="p-2 pending">Pending</p>
                        <button class="cancel" data-id="<?php echo $order['id']; ?>">Cancel</button>
                    </div>
                    <p class="mb-1">Subtotal: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
                   
                </div>
            </div>
            <hr>
            <p class="total-row d-flex justify-content-end">Total: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
        </div>
    <?php endforeach; ?>
</div>
<script>
 document.querySelectorAll('.cancel').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id'); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../function/php/update_order_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
    if (xhr.status == 200) {
        console.log(xhr.responseText); 
        showSection('cancelled-orders'); 
    } else {
        console.log('Error:', xhr.statusText);
    }
};

        xhr.send('id=' + orderId + '&status=Cancel'); 
    });
});

</script>


<!-- Displaying To-Ship Orders -->
<div class="to-ship">
    <?php foreach ($to_ship_orders as $order): ?>
        <div class="card p-3 mt-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../../../../assets/img/product/<?php echo htmlspecialchars($order['product_img']); ?>" alt="Product Image" class="img-fluid" style="border-radius: 10px;" />
                </div>
                <div class="col-md-7">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h5>
                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                </div>
                <div class="col-md-3 text-end">
                    <p class="p-2 to-ship-w">To Ship</p>
                    <p class="mb-1">Subtotal: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
                  
                </div>
            </div>
            <hr>
            <p class="total-row d-flex justify-content-end">Total: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Displaying To-Receive Orders -->
<div class="to-receive">
    <?php foreach ($to_receive_orders as $order): ?>
        <div class="card p-3 mt-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../../../../assets/img/product/<?php echo htmlspecialchars($order['product_img']); ?>" alt="Product Image" class="img-fluid" style="border-radius: 10px;" />
                </div>
                <div class="col-md-7">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h5>
                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                </div>
                <div class="col-md-3 text-end">
                    <p class="p-2 to-receive-w">To Receive</p>
                    <p class="mb-1">Subtotal: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
                   
                </div>
            </div>
            <hr>
            <p class="total-row d-flex justify-content-end">Total: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Displaying Completed Orders -->
<div class="received-orders">
    <?php foreach ($completed_orders as $order): ?>
        <div class="card p-3 mt-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../../../../assets/img/product/<?php echo htmlspecialchars($order['product_img']); ?>" alt="Product Image" class="img-fluid" style="border-radius: 10px;" />
                </div>
                <div class="col-md-7">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h5>
                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                </div>
                <div class="col-md-3 text-end">
                    <p class="p-2 completed-orders">Completed Orders</p>
                    <p class="mb-1">Subtotal: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
                
                </div>
            </div>
            <hr>
            <p class="total-row d-flex justify-content-end">Total: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
        </div>
    <?php endforeach; ?>
</div>


<!-- Displaying Cancelled Orders -->
<div class="cancelled-orders">
    <?php foreach ($cancelled_orders as $order): ?>
        <div class="card p-3 mt-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../../../../assets/img/product/<?php echo htmlspecialchars($order['product_img']); ?>" alt="Product Image" class="img-fluid" style="border-radius: 10px;" />
                </div>
                <div class="col-md-7">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($order['product_name']); ?></h5>
                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                </div>
                <div class="col-md-3 text-end">
                    <p class="p-2 cancelled-order">Cancelled Orders</p>
                    <p class="mb-1">Subtotal: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
                 
                </div>
            </div>
            <hr>
            <p class="total-row d-flex justify-content-end">Total: <span class="price">₱<?php echo number_format($order['total_amount'], 2); ?></span></p>
        </div>
    <?php endforeach; ?>
</div>


  </div>

  <script>
 
 document.addEventListener("DOMContentLoaded", function () {
        showSection('orders');

        document.querySelectorAll('.order-button button').forEach(button => {
            button.addEventListener('click', function (event) {
                const section = this.textContent.trim().toLowerCase().replace(' ', '-');
                showSection(section, event);
            });
        });
    });

    function showSection(section, event = null) {
    document.querySelectorAll('.order-button button').forEach(button => {
        button.classList.remove('button-highlight');
        if (button.textContent.trim().toLowerCase().replace(' ', '-') === section) {
            button.classList.add('button-highlight');
        }
    });

    document.querySelectorAll('.orders, .to-ship, .to-receive, .received-orders, .cancelled-orders').forEach(div => {
        div.style.display = 'none';
    });

    document.querySelector(`.${section}`).style.display = 'block';
}
  </script>
</body>
<!--Header End-->


<script src=" https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js">
</script>
<script src="../../function/script/chatbot-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>

</html>