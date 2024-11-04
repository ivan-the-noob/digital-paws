<?php 
require '../../../../db.php';

$product = null; // Initialize the product variable
$products = []; // Initialize an array to hold all products

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the query to fetch the specific product
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the product details if found
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
    $stmt->close();

    // Fetch recommended products excluding the chosen product
    $stmt = $conn->prepare("SELECT * FROM product WHERE id != ?");
    $stmt->bind_param("i", $id); // Exclude the product with the chosen ID
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
}

$conn->close(); 
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy Now</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/buy-now.css">
</head>

<body>
  <!-- Navbar -->
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
        <div class="dropdown">
          <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../../../../assets/img/customer.jfif" alt="" class="profile">
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="../../../users/web/api/dashboard.html">Profile</a>
            <a class="dropdown-item" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Product Section -->
  <div class="container">
  <section class="product row">
    <!-- Main Product Details -->
    <div class="col-md-6">
        <img src="../../../../assets/img/product/<?= htmlspecialchars($product['product_img']) ?>" alt="Product Image" class="img-fluid">
    </div>
    <div class="col-md-5">
        <div class="product-text">
            <p>Digital Paws</p>
            <h1><?= htmlspecialchars($product['product_name']) ?></h1>
            <p class="stock">Stock: <?= htmlspecialchars($product['quantity']) ?></p>
            <p class="price">₱<?= htmlspecialchars(number_format($product['cost'], 2)) ?> PHP</p>
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
            <button class="buy-it-now mt-2" data-bs-toggle="modal" data-bs-target="#orderDetailsModal" onclick="openOrderDetailsModal()">Buy it now</button>
        </div>
    </div>
    <script>
function fetchProductDetails(id) {
    fetch(`../../function/php/detail_product.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('.product img').src = `../../../../assets/img/product/${data.product_img}`;
            document.querySelector('.product h1').innerText = data.product_name;
            document.querySelector('.stock').innerText = `Stock: ${data.quantity}`;
            document.querySelector('.price').innerText = `₱${parseFloat(data.cost).toFixed(2)} PHP`;
            document.querySelector('#quantity').value = 1; 

            const productItems = document.querySelectorAll('.row.px-5 .product-item');
            productItems.forEach(item => {
                if (item.getAttribute('data-id') == id) {
                    item.remove(); 
                }
            });
        })
        .catch(error => console.error('Error fetching product details:', error));
}

  
  
  </script>

  <!-- Bootstrap Modal for Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Customer Information Card -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title">Customer Information</p>
                                <div class="context">
                                  <p class="name">Ivan Ablanida</p>
                                  <p>0931232141</p>
                                  <p>Blk 4. Lot 45 San Agustin Tmc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method Card -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Payment Method</h5>
                                <div class="form-check d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <input type="radio" id="payment-cash" name="paymentMethod" value="cash" class="form-check-input">
                                        <label for="payment-cash" class="form-check-label">Cash on delivery</label>
                                    </div>
                                    <span class="cod">COD</span>
                                </div>
                                <div class="form-check d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <input type="radio" id="payment-gcash" name="paymentMethod" value="gcash" class="form-check-input">
                                        <label for="payment-gcash" class="form-check-label">Gcash</label>
                                    </div>
                                  
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                
                <!-- First Column: Image -->
                <div class="col-12 col-md-4 mb-3 mb-md-0 text-center">
                    <img id="modalProductImage" src="" alt="Product Image" class="img-fluid">
                    
                </div>
                
                <!-- Second Column: Name and Size -->
                <div class="col-6 col-md-4 mb-3 mb-md-0 text-center">
                    <h6 id="modalProductName">Product Name</h6>
                    <p id="modalProductSize">Size: 25kg</p>
                </div>
                
                <!-- Third Column: Quantity Controls and Price -->
                <div class="col-12 col-md-4 d-flex flex-column align-items-center text-center">
                    <div class="d-flex justify-content-center mb-2">
                        <button class="quantity-btn" id="decrement">-</button>
                        <input type="number" class="form-control mx-2" id="quantity" min="1" value="1" style="max-width: 40px;">
                        <button class="quantity-btn" id="increment">+</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


                    
                    <!-- Order Summary Card -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Order Summary</h5>
                                <p>Subtotal: ₱<span id="subtotalAmount">123.00</span></p>
                                <p>Shipping Fee: ₱<span id="shippingFee">69.00</span></p>
                                <h6>Total: ₱<span id="totalAmount">192.00</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Proceed to Checkout</button>
            </div>
        </div>
    </div>
</div>


<script>
  function openOrderDetailsModal() {
    // Get product details
    const productImage = document.querySelector('.product img').src;
    const productName = document.querySelector('.product h1').innerText;
    const productPrice = document.querySelector('.price').innerText;
    const productQuantity = document.querySelector('#quantity').value; // get the input value
    const selectedSize = document.querySelector('.size-button.selected'); // get selected size button

    // Update modal content
    document.getElementById('modalProductImage').src = productImage;
    document.getElementById('modalProductName').innerText = productName;
    document.getElementById('modalProductPrice').innerText = productPrice;
    document.getElementById('modalProductQuantity').innerText = `Quantity: ${productQuantity}`;
    document.getElementById('modalProductSize').innerText = selectedSize ? selectedSize.innerText : 'Size not selected';

    // Set static values for subtotal and total
    document.getElementById('subtotalAmount').innerText = (parseFloat(productPrice.replace('₱', '').replace(',', '')) * productQuantity).toFixed(2);
    document.getElementById('totalAmount').innerText = (parseFloat(document.getElementById('subtotalAmount').innerText) + 69.00).toFixed(2); // Adding static shipping fee
}

</script>
  
  

    <!-- Recommended Products Section -->

 
    <h3 class="mt-5">You may also like</h3>
<div class="row px-5">
<?php if (empty($products)): ?>
    <div class="col-12">
        <p>No products available.</p>
    </div>
<?php else: ?>
  <?php foreach ($products as $item): ?>
    <div class="col-md-3 col-sm-6 col-12 mb-4 product-item" data-id="<?= $item['id'] ?>" onclick="fetchProductDetails(<?= $item['id'] ?>)">
        <div class="product-item">
            <div class="img-product">
                <img src="../../../../assets/img/product/<?= htmlspecialchars($item['product_img']) ?>" alt="Product Image" class="img-fluid mb-2">
            </div>
            <h5 class="product-title"><?php echo htmlspecialchars($item['product_name']); ?></h5>
            <div class="product-price">₱<?php echo number_format($item['cost'], 2); ?> PHP</div>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</div>
</section>




  </div>

  <!-- Chat Bot -->
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
        <!-- Additional buttons as needed -->
      </div>
    </div>
    <div class="line"></div>
    <div class="admin mt-3">
      <div class="admin-chat">
        <img src="../../../../assets/img/vet logo.jpg" alt="Admin">
        <p>Admin</p>
      </div>
      <p class="text">Hello, I am Chat Bot. Please ask me a question by pressing the question buttons.</p>
    </div>
  </div>

</body>
<script src="../../function/script/select-size.js"></script>
<script src="../../function/script/product-size.js"></script>
<script src="../../function/script/chatbot_questionslide.js"></script>
<script src="../../function/script/chatbot-toggle.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</html>


