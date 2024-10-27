<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/buy-now.css">

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand d-none d-md-block" href="#">
        <img src="../../../../assets/img/logo.png" alt="Logo" width="30" height="30">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          style="stroke: black; fill: none;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>

      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../../../../../user.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Product</a>
          </li>
        </ul>
          <!--Notification-->
        <div class="d-flex ml-auto align-items-center">
          <div class="dropdown first-dropdown">
            <button class="" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <h5 class="notification-title">Notification</h5>
                <div class="notification-content alert alert-success">
                  <strong>Appointment Confirmed!</strong>
                  <p class="notification-text">Your appointment has been confirmed!</p>
                  <p class="code">Code:   OVAS-01234</p>
                  <a href="/features/users/web/api/appointment.html" onclick="localStorage.setItem('showBookedHistory', 'true');">View Details</a>
              </div>
                <div class="notification-content alert-primary">
                    <strong>Successfully Booked!</strong>
                    <p class="notification-text">You successfully booked!</p>
                </div>
                <div class="notification-content alert-danger">
                  <strong>Rejected</strong>
                  <p class="notification-text">Your appointment has been rejected.</p>
              </div>
          </div>
        </div>
          <!--Notification End-->
          <div class="dropdown">
              <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../../../../assets/img/customer.jfif" alt="" class="profile">
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="../../../users/web/api/dashboard.html">Profile</a>
                  <a class="dropdown-item" href="login.html">Logout</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
        <section class="product row">
            <div class="col-md-6">
                <img src="../../../../assets/img/food/1111.PNG" alt="Product Image" class="img-fluid">
            </div>
            <div class="col-md-5">
              <div class="product-text">
                <p>Digital Paws</p>
                <h1>WOMEN SCRUB LEATHER</h1>
                <p class="stock">Stock: 10</p>
                <p class="price">₱249.00 PHP</p>
                <p class="size">Size</p>
                <div class="size-button-button">
                    <button class="size-button" onclick="selectSize(this)">1kg</button>
                    <button class="size-button" onclick="selectSize(this)">25kg</button>
                </div>
                <p class="mb-0 mt-3">Quantity</p>
                <div class="quantity-wrapper">
                    <button class="quantity-btn" id="decrement">-</button>
                    <input type="number" class="form-control" id="quantity" min="1" value="1">
                    <button class="quantity-btn" id="increment">+</button>
                </div>
                <button class="add-to-cart mt-2">Add to cart</button>
                <button class="buy-it-now mt-2">Buy it now</button>
              </div>
            </div>
            <h3 class="mt-5">You make also like</h3>
            <div class="row px-5">
              <div class="col-md-3 col-sm-6 col-12 mb-4">
                  <div class="product-item">
                    <div class="img-product">
                      <img src="../../../../assets/img/food/1111.PNG" alt="Product Image" class="img-fluid mb-2">
                    </div>
                      <h5 class="product-title">WOMEN SCRUB LEATHER</h5>
                      <div class="product-price">₱45.00 PHP</div>
                    
                  </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12 mb-4">
                  <div class="product-item">
                    <div class="img-product">
                      <img src="../../../../assets/img/food/1111.PNG" alt="Product Image" class="img-fluid mb-2">
                    </div>
                      <h5 class="product-title">WOMEN SCRUB LEATHER</h5>
                      <div class="product-price">₱45.00 PHP</div>
                    
                  </div>
              </div>
            
              <div class="col-md-3 col-sm-6 col-12 mb-4">
                  <div class="product-item">
                    <div class="img-product">
                      <img src="../../../../assets/img/food/1111.PNG" alt="Product Image" class="img-fluid mb-2">
                    </div>
                      <h5 class="product-title">WOMEN SCRUB LEATHER</h5>
                      <div class="product-price">₱45.00 PHP</div>
                    
                  </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12 mb-4">
                  <div class="product-item">
                    <div class="img-product">
                      <img src="../../../../assets/img/food/1111.PNG" alt="Product Image" class="img-fluid mb-2">
                    </div>
                      <h5 class="product-title">WOMEN SCRUB LEATHER</h5>
                      <div class="product-price">₱45.00 PHP</div>
                    
                  </div>
              </div>
              
              </div>
        </section>
    </div>
  

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
    <!--Chat Bot End-->

 
</body>
<script src="../../function/script/select-size.js"></script>
<script src="../../function/script/product-size.js"></script>
<script src="../../function/script/chatbot_questionslide.js"></script>
<script src="../../function/script/chatbot-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</html>