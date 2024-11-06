<?php
session_start(); // Start the session
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

// Fetch user details based on session email
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
  $stmt = $conn->prepare("SELECT name, contact_number, home_street, address_search FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if (!$user) {
    echo "User not found.";
    exit;
  }

  // Sanitize user data
  $name = htmlspecialchars($user['name']);
  $contactNumber = htmlspecialchars($user['contact_number']);
  $homeStreet = htmlspecialchars($user['home_street']);
  $addressSearch = htmlspecialchars($user['address_search']);
} else {
  echo "User not logged in.";
  exit;
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
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
          </path>
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
          <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
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
        <img src="../../../../assets/img/product/<?= htmlspecialchars($product['product_img']) ?>"
          alt="Product Image" class="img-fluid">
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
            <button class="quantity-btn" id="decrement-btn">-</button> <!-- Decrement button -->
            <input type="number" class="form-control" id="quantity" min="1" value="1">
            <!-- Quantity input -->
            <button class="quantity-btn" id="increment-btn">+</button> <!-- Increment button -->
          </div>

          <button class="add-to-cart mt-2">Add to cart</button>
          <button class="buy-it-now mt-2" data-bs-toggle="modal" data-bs-target="#orderDetailsModal"
            onclick="openOrderDetailsModal()">Buy it now</button>
        </div>
      </div>
      <script>
        function fetchProductDetails(id) {
          fetch(`../../function/php/detail_product.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
              document.querySelector('.product img').src =
                `../../../../assets/img/product/${data.product_img}`;
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
      <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered justify-content-center">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="../../function/php/checkout_process.php"
                enctype="multipart/form-data">
                <div class="row">

                  <div class="col-md-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-title">Customer Information</p>
                        <div class="context">
                          <p class="name" name="name"></p>
                          <p name="contact-num"><?php echo $contactNumber; ?></p>
                          <p name="address-search"><?php echo $addressSearch; ?></p>
                        </div>
                        <!-- Hidden inputs for Customer Information -->
                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                        <input type="hidden" name="contact-num"
                          value="<?php echo $contactNumber; ?>">
                        <input type="hidden" name="address-search"
                          value="<?php echo $addressSearch; ?>">
                      </div>
                    </div>
                  </div>

                  <!-- Payment Method Card -->
                  <div class="col-md-6 mb-3">
                    <div class="card payment-method">
                      <div class="card-body">
                        <h5 class="card-title">Payment Method</h5>
                        <div
                          class="form-check d-flex justify-content-between align-items-center mb-3 form-payment">
                          <div>
                            <input type="radio" id="payment-cash" name="paymentMethod"
                              value="cash" class="form-check-input">
                            <label for="payment-cash" class="form-check-label">Cash on
                              delivery</label>
                          </div>
                          <span class="cod">COD</span>
                        </div>
                        <div
                          class="form-check d-flex justify-content-between align-items-center mb-3 form-payment">
                          <div>
                            <input type="radio" id="payment-gcash" name="paymentMethod"
                              value="gcash" class="form-check-input">
                            <label for="payment-gcash"
                              class="form-check-label">Gcash</label>
                          </div>
                        </div>

                        <!-- Gcash specific inputs and image -->
                        <div id="gcash-details" style="display: none;">
                          <img src="../../../../assets/img/gcash.jfif" alt="Gcash"
                            class="img-fluid mb-3 gcash">

                          <!-- Hidden inputs for Gcash -->
                          <input type="hidden" name="paymentMethod" value="gcash">
                          <input type="hidden" name="screenshot" value="">
                          <input type="hidden" name="reference" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12 col-md-5 mb-3 mb-md-0 text-center">
                            <img id="modalProductImage" src="" alt="Product Image"
                              class="img-fluid">
                          </div>

                          <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <h6 id="modalProductName" name="product-name">Product Name</h6>
                            <p id="modalProductSize" name="size">Size: 25kg</p>
                          </div>

                          <div class="col-12 col-md-4 d-flex justify-content-end mt-auto">
                            <div class="mb-2">
                              <div class="d-flex justify-content-end">
                                <div id="quantity-display" name="quantity">1x</div>
                              </div>
                              <p class="mb-0 d-flex justify-content-center mt-2"
                                id="total-cost-1" name="cost">
                                ₱<?= htmlspecialchars(number_format($product['cost'], 2)) ?>
                              </p>
                              <!-- Hidden Inputs for Product Details -->
                              <input type="hidden" name="product-name"
                                value="<?= htmlspecialchars($product['product_name']) ?>">
                              <input type="hidden" name="size" value="25kg">
                              <input type="hidden" name="quantity" value="1">
                              <input type="hidden" name="cost"
                                value="<?= htmlspecialchars(number_format($product['cost'], 2)) ?>">
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
                        <div class="d-flex justify-content-between">
                          <p>Subtotal:</p>
                          <p class="mb-0 d-flex justify-content-center mt-2" id="total-cost-2"
                            name="sub-total">
                            ₱<?= htmlspecialchars(number_format($product['cost'], 2)) ?>
                          </p>
                          <input type="hidden" name="sub-total"
                            value="<?= htmlspecialchars(number_format($product['cost'], 2)) ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                          <p>Shipping Fee:</p>
                          <p>₱<span id="shippingFee" name="shipping-fee">69.00</span></p>
                          <input type="hidden" name="shipping-fee" value="69.00">
                        </div>
                        <div class="d-flex justify-content-between">
                          <h6>Total:</h6>
                          <h6><span id="totalAmount" name="total-amount">192.00</span></h6>
                          <input type="hidden" name="total-amount" value="192.00">
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
            </div>
          </div>
        </div>
      </div>


      <script>
        const unitCost = <?php echo $product['cost']; ?>; // Get product cost from PHP

        const quantityInput = document.getElementById("quantity");
        const incrementBtn = document.getElementById("increment-btn"); // Increment button
        const decrementBtn = document.getElementById("decrement-btn"); // Decrement button

        // Get the shipping fee element and its value
        const shippingFeeElement = document.getElementById("shippingFee");
        const shippingFee = parseFloat(shippingFeeElement
          .textContent); // Assuming the shipping fee is in plain text, like "69.00"

        // Function to update the total cost (Subtotal)
        function updateTotalCost(quantity, totalCostElement) {
          const totalCost = (unitCost * quantity).toFixed(2); // Calculate total cost based on quantity
          totalCostElement.textContent = `₱${totalCost} PHP`; // Update total cost
          return totalCost; // Return the calculated total cost for further calculations
        }

        // Function to update the total amount (Subtotal + Shipping Fee)
        function updateTotalAmount() {
          // Get the updated subtotal from total-cost-2
          const subtotal = parseFloat(document.getElementById("total-cost-2").textContent.replace("₱", "")
            .trim());

          // Calculate the total (Subtotal + Shipping Fee)
          const totalAmount = (subtotal + shippingFee).toFixed(2); // Sum of subtotal and shipping fee

          // Update the total amount display
          document.getElementById("totalAmount").textContent = `₱${totalAmount}`;
        }

        // Sync the input value with quantity and update the display
        function syncQuantity(value) {
          quantityInput.value = value;

          // Update both total cost elements
          const totalCostDisplay1 = document.getElementById("total-cost-1");
          const totalCostDisplay2 = document.getElementById("total-cost-2");

          const subtotal = updateTotalCost(value, totalCostDisplay1); // Update total cost for the first div
          updateTotalCost(value, totalCostDisplay2); // Update total cost for the second div

          // Update the total amount (Subtotal + Shipping Fee)
          updateTotalAmount();
        }

        // Increment the quantity and update displays
        incrementBtn.addEventListener("click", () => {
          const newValue = parseInt(quantityInput.value) + 1; // Increment the value by 1
          syncQuantity(newValue); // Update quantity input and display
        });

        // Decrement the quantity and update displays
        decrementBtn.addEventListener("click", () => {
          if (quantityInput.value > 1) {
            const newValue = parseInt(quantityInput.value) - 1; // Decrement the value by 1
            syncQuantity(newValue); // Update quantity input and display
          }
        });

        // Update display when the quantity input is changed manually
        quantityInput.addEventListener("input", () => {
          const newValue = Math.max(1, parseInt(quantityInput
            .value)); // Ensure the value doesn't go below 1
          syncQuantity(newValue); // Update quantity input and display
        });

        // Initialize the display when the page loads
        document.addEventListener('DOMContentLoaded', () => {
          syncQuantity(quantityInput.value); // Ensure the initial display reflects the input value
        });
      </script>


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
          document.getElementById('modalProductSize').innerText = selectedSize ? selectedSize.innerText :
            'Size not selected';

          // Set static values for subtotal and total
          document.getElementById('subtotalAmount').innerText = (parseFloat(productPrice.replace('').replace(
            ',', '')) * productQuantity).toFixed(2);
          document.getElementById('totalAmount').innerText = (parseFloat(document.getElementById('subtotalAmount')
            .innerText) + 69.00).toFixed(2); // Adding static shipping fee
        }
      </script>

      <script>
        // Get the radio buttons and the Gcash specific details container
        const paymentCash = document.getElementById("payment-cash");
        const paymentGcash = document.getElementById("payment-gcash");
        const gcashDetails = document.getElementById("gcash-details");

        // Show/hide Gcash details based on the selected payment method
        paymentGcash.addEventListener("change", () => {
          if (paymentGcash.checked) {
            gcashDetails.style.display = "block"; // Show Gcash details
          }
        });

        paymentCash.addEventListener("change", () => {
          if (paymentCash.checked) {
            gcashDetails.style.display = "none"; // Hide Gcash details
          }
        });
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
            <div class="col-md-3 col-sm-6 col-12 mb-4 product-item" data-id="<?= $item['id'] ?>"
              onclick="fetchProductDetails(<?= $item['id'] ?>)">
              <div class="product-item">
                <div class="img-product">
                  <img src="../../../../assets/img/product/<?= htmlspecialchars($item['product_img']) ?>"
                    alt="Product Image" class="img-fluid mb-2">
                </div>
                <h5 class="product-title"><?= htmlspecialchars($product['product_name']) ?></h5>
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