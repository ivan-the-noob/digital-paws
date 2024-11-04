<?php

session_start();
$email = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Vet Animal Clinic & Grooming Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="features/users/css/index.css">
     <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="navbar-container">
<nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
            <a class="navbar-brand d-none d-lg-block" href="#">
                    <img src="assets/img/logo.png" alt="Logo" width="30" height="30">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="stroke: black; fill: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about-us">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Contact Us</a>
                        </li>
                    </ul>
                    <div class="d-flex ml-auto">
                        <?php if ($email): ?>
                            <div class="dropdown second-dropdown">
                                <button class="btn" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/img/customer.jfif" alt="Profile Image" class="profile">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="/features/users/web/api/dashboard.html">Profile</a></li>
                                    <li><a class="dropdown-item" href="features/users/function/authentication/logout.php">Logout</a></li>
                                </ul>
                            </div>


                        <?php else: ?>
                        <a href="features/users/web/api/login.php" class="btn-theme" type="button">Login</a>
                        <?php endif; ?>
                       
                    </div>
        </nav>
    </div>
    <section class="front relative-container">
        <div class="paws">
            <img src="assets/img/foot2.png" class="foot2" alt="Paw Print 2">
            <img src="assets/img/foot3.png" class="foot3" alt="Paw Print 3">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-1 order-md-2 text-center">
                    <img src="assets/img/about_us.png" alt="Vet Logo" class="img-fluid">
                </div>
                <div class="col-md-6 order-2 order-md-1 text-md-left mb-4 mb-md-0 front-text">
                    <h4 class="mt-5">Book your pet's next appointment with ease!</h4>
                    <p class="mb-4 fs-5 mt-2" style="width: 70%;">Welcome to Happy Vet Animal Clinic & Grooming Center, your one-stop destination for
                        pet
                        grooming and care.</p>
                    <a href="features/users/web/api/appointment.php"><button class="btn btn-primary mb-2">Book an
                            appointment</button>
                    </a>
                    <div class="satisfied-customers d-flex mt-4">
                        <div class="profile-pics">
                            <img src="assets/img/satisfied.png" alt="Profile" class="profile">
                        </div>
                        <div class="text">
                            <p class="number mb-0" style="font-weight: 800">900+</p>
                            <p class="label">Satisfied pet owners</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    </div>

    <div class="wave-container1" id="about-us">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 160" class="wave1">
            <!-- Top Border Path -->
            <path fill="none" stroke="#EA6B35" stroke-width="4"
                d="M0,64L60,74.7C120,85,240,107,360,106.7C480,107,600,85,720,69.3C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96" />
            <!-- Wave Path -->
            <path fill="#F8EBDC" fill-opacity="1"
                d="M0,64L60,74.7C120,85,240,107,360,106.7C480,107,600,85,720,69.3C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,160L0,160Z" />
        </svg>
    </div>


    <section class="services" id="services">
        <p class="text-center">We offer you</p>
        <h2 class="text-center">Our Services</h2>

        <div class="checkbox-container text-start">
            <label>
                <input type="checkbox" id="medical-checkbox" onclick="filterServices()" checked> Medical Services
            </label>
            <label>
                <input type="checkbox" id="non-medical-checkbox" onclick="filterServices()"> Non-Medical Services
            </label>
        </div>

        <div class="container mt-4">
            <div class="slider-container">
                <div class="slider-wrapper">
                    <?php
          require 'db.php';

          include 'features/admin/function/php/view_service.php';



          ?>
                    <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                    <div
                        class="service-card <?php echo $service['service_type'] == 'medical' ? 'medical-service' : 'non-medical-service'; ?>">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="card-header">
                                    <i class="fa-solid fa-stethoscope mr-2"></i>
                                    <h5 class="card-title mt-2">
                                        <?php echo htmlspecialchars($service['service_name']); ?></h5>
                                    <?php if ($service['discount'] > 0): ?>
                                    <div class="discount-label text-center">
                                        <p><?php echo round($service['discount']); ?>% OFF</p>
                                    </div>
                                    <?php endif; ?>
                                    <p class="card-text"><?php echo htmlspecialchars($service['info']); ?></p>
                                </div>
                                <div class="card-footer">
                                    <p style="font-weight: 400; font-size: 14px; color: #808080;" class="mb-0">Service
                                        fee</p>
                                    <div class="price-flex d-flex">
                                        <p class="price"
                                            style="display: flex; justify-content: center; align-items: center;">PHP</p>
                                        <p class="price cost" style="font-size: 25px; font-weight: 600;">
                                            <?php echo number_format($service['cost'], 2); ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>



                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container how-it-works">
            <div class="row justify-content-center mb-4">
                <div class=" how-headings col-12 text-center mt-4">
                    <p class="mb-0">Book in just a few steps</p>
                    <h2>How It Works</h2>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row how-img">
                        <div class="col-md-6 step">
                            <img src="assets/img/how it works/1.png" alt="Choose A Service" class="step-icon"
                                width="60">
                            <h5>Choose A Service</h5>
                            <p>Select from a range of grooming services catered to your pet’s needs.</p>
                        </div>
                        <div class="col-md-6 step">
                            <img src="assets/img/how it works/2.png" alt="Select A Date" class="step-icon" width="60">
                            <h5>Select A Date</h5>
                            <p>Choose the date that works best for you and your pet’s busy schedule.</p>
                        </div>
                        <div class="col-md-6 step">
                            <img src="assets/img/how it works/3.png" alt="Provide Pet Details" class="step-icon"
                                width="60">
                            <h5>Provide Pet Details</h5>
                            <p>Fill up details about your pet to help us understand their specific needs.</p>
                        </div>
                        <div class="col-md-6 step">
                            <img src="assets/img/how it works/4.png" alt="Book Appointment" class="step-icon"
                                width="60">
                            <h5>Book Your Appointment</h5>
                            <p>Book your pet’s grooming appointment effortlessly at your convenience.</p>
                        </div>
                    </div>
                </div>

                <!-- Right section with image -->
                <div class="col-md-4 d-flex justify-content-center dog-image">
                    <img src="assets/img/how it works/dog.png" alt="Dog Image" class="img-fluid">
                </div>
            </div>
        </div>

    </section>
    </div>



    <section class="essentials py-5">
        <div class="how-headings col-12 text-center mt-4">
            <p class="mb-0">Explore pet care</p>
            <h2 class="mb-4">Essentials</h2>
        </div>
        <div class="container">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-3 col-md-4 col-12 mb-3">
                    <div class="essentials-button d-flex flex-column align-items-start">
                        <button>Pet Food</button>
                        <button>Pet Toys</button>
                        <button>Supplements</button>
                        <a href="#">More</a>
                    </div>
                </div>
                <?php
          require 'db.php';

          // Modify SQL to get the last 6 products
          $sql = "SELECT * FROM product ORDER BY id DESC LIMIT 6";
          $result = $conn->query($sql);
        ?>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row">
                        <!-- Product 1 -->
                        <?php if ($result->num_rows > 0): ?>
                        <?php while ($product = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="product">
                                <!-- Display product image -->
                                <img src="assets/img/product/<?= $product['product_img'] ?>" alt="Product Image">

                    <!-- Display product name -->
                    <h5 class=" mt-4" name="product_name"><?= htmlspecialchars($product['product_name']) ?>
                                </h5>

                                <!-- Display product description -->
                                <p name="description"><?= htmlspecialchars($product['description']) ?></p>

                                <!-- Display product price -->
                                <div class="d-flex prices">
                                    <p class="tag align-items-center mb-0 d-flex">PHP</p>
                                    <p class="price" name="cost">
                                        <?= htmlspecialchars(number_format($product['cost'], 2)) ?></p>
                                </div>

                                <!-- Action buttons -->
                                <div class="d-flex justify-content-between item-btn">
                                <a href="features/users/web/api/buy-now.php?id=<?= $product['id'] ?>&type=<?= htmlspecialchars($product['type']) ?>" class="btn buy-now">
                                    BUY NOW!
                                </a>
                                    <button class="btn add-to-cart"><i class="fas fa-shopping-cart"></i></button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <p>No products available.</p>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </section>






    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="assets/img/about_us2.png" alt="About Us" class="img-fluid about-img">
                </div>
                <div class="col-md-6 p-3 text-section">
                    <h2>About Us</h2>
                    <p>
                        Welcome to Pet Shop Booking, your trusted companion in pet grooming and care.
                        At Pet Shop Booking, we understand that your pets are more than just animals—they’re beloved
                        members of your family.
                    </p>
                    <p>
                        Our experienced team is passionate about animals and committed to their well-being. We offer a
                        range of services
                        tailored to meet the unique needs of each pet, ensuring they leave happy and healthy.
                    </p>
                    <a href="#" class="btn learn-more-btn">Learn more</a>
                </div>

            </div>
        </div>
    </section>




    <div class="modal fade modal-bottom-to-top" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="assets/img/food/1111.PNG" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <div class="product-text">
                                <p class="stock">Stock: 10</p>
                                <p class="price">₱249.00 PHP</p>
                            </div>
                        </div>
                        <div class="underline"></div>
                        <p class="size mb-0 mt-3">Size</p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="choose-us py-5" id="choose-us">
        <h3 class="mb-4" id="review">Why Choose Us</h3>
        <div class="container ">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card-custom p-3 review-box" id="translate-1">
                        <div class="d-flex align-items-center">
                            <img src="assets/img/customer.jfif" alt="Ivan Ablanida" width="50" height="50">
                            <div class="ml-3">
                                <p class="testimonial-title">Ivan Ablanida</p>
                            </div>
                        </div>
                        <p class="mt-3">Booking a pet appointment at Pawfect was a breeze. The staff was incredibly
                            friendly, and
                            the online booking system made it simple to schedule a visit. Highly recommended for anyone
                            looking for a
                            hassle-free experience.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card-custom p-3 review-box" id="translate-2">
                        <div class="d-flex align-items-center">
                            <img src="assets/img/customer.jfif" alt="Jannray Mostajo" width="50" height="50">
                            <div class="ml-3">
                                <p class="testimonial-title">Jannray Mostajo</p>
                            </div>
                        </div>
                        <p class="mt-3">The appointment booking process was seamless. The user-friendly platform allowed
                            me to
                            easily select a time slot that fit my schedule. The clinic's professionalism and care for my
                            pet made the
                            experience even better.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card-custom p-3 review-box" id="translate-3">
                        <div class="d-flex align-items-center">
                            <img src="assets/img/customer.jfif" alt="Prince Jherico" width="50" height="50">
                            <div class="ml-3">
                                <p class="testimonial-title">Prince Jherico</p>
                            </div>
                        </div>
                        <p class="mt-3">I was impressed with how easy it was to book an appointment for my pet. The
                            online system
                            was intuitive, and I appreciated the reminder notifications. The staff was welcoming and
                            knowledgeable,
                            making the entire process smooth and stress-free.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card-custom p-3 review-box" id="translate-4">
                        <div class="d-flex align-items-center">
                            <img src="assets/img/customer.jfif" alt="Johnloyd Belen" width="50" height="50">
                            <div class="ml-3">
                                <p class="testimonial-title">Johnloyd Belen</p>
                            </div>
                        </div>
                        <p class="mt-3">Booking a pet appointment at Pawfect was incredibly convenient. The staff was
                            responsive and
                            caring, ensuring a positive experience for both me and my pet. The efficient booking system
                            saved me time
                            and made the process effortless.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="review">
        <div class="container review-section">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center">Leave Us A Review</h2>
                    <form class="review-form">
                        <div class="form-group">
                            <textarea class="form-control" id="comment" rows="4"
                                placeholder="Leave Your Comment"></textarea>
                        </div>
                        <button type="submit" class="mt-3 submit ">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <div class="container contact-section">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 contact-card">
                <h3>Contact Us</h3>
                <p><i class="bi bi-telephone-fill"></i> (09) 33-818-2822</p>
                <p><i class="bi bi-envelope-fill"></i> willie.jennings@example.com</p>
                <p><i class="bi bi-envelope-fill"></i> bill.sanders@example.com</p>
                <p><i class="bi bi-geo-alt-fill"></i> 2118 Thornridge Cir, Syracuse, Connecticut 35624</p>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-4 col-md-6 form-section">
                <form>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" id="phone" placeholder="Phone number">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="message" rows="5"
                            placeholder="Leave your message here"></textarea>
                    </div>
                    <button type="submit" class="btn submit-btn">Submit</button>
                </form>
            </div>

            <!-- Illustration -->
            <div class="col-lg-4 col-md-12 illustration text-center">
                <img src="assets/img/contact.png" alt="Contact Illustration">
            </div>
        </div>
    </div>
    <div class="wave-container1" id="about-us">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 160" class="wave1">
            <path fill="#7A3015" fill-opacity="1"
                d="M0,80L40,72C80,64,160,48,240,56C320,64,400,96,480,98.65C560,101.5,640,74.5,720,69.35C800,64,880,80,960,77.35C1040,74.5,1120,53.5,1200,48C1280,42.5,1360,53.5,1400,58.65L1440,64L1440,160L1400,160C1360,160,1280,160,1200,160C1120,160,1040,160,960,160C880,160,800,160,720,160C640,160,560,160,480,160C400,160,320,160,240,160C160,160,80,160,40,160L0,160Z">
            </path>
        </svg>
    </div>

    <footer class="footer" id="reviews">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Pawfect</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Our Services</a></li>
                        <li><a href="#review">Review</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i>
                                Facebook</a></li>
                        <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i>
                                Instagram</a></li>
                        <li><a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i> YouTube</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: bardyardpets@gmail.com</p>
                    <p>Phone: 09338182822</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>&copy; 2024 Pawfect. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

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
            <button onclick="sendResponse('How to log in?')">How to log in?</button>
            <button onclick="sendResponse('How to book?')">How to book?</button>
            <button onclick="sendResponse('What are the services?')">What are the services?</button>
            <button onclick="sendResponse('Contact information?')">Contact information?</button>
        </div>
        
        <div class="admin mt-3">
            <div class="admin-chat">
                <img src="assets/img/logo.png" alt="Admin">
                <p>Admin</p>
            </div>
            <p class="text" id="typing-text">Hello, I am Chat Bot. Please Ask me a question just by pressing the question buttons.</p>
        </div>
      
    </div>
    <div class="line"></div>
</div>





</body>
<script src="features/users/function/script/select-size.js"></script>
<script src="features/users/function/script/chat-bot.js"></script>
<script src="features/users/function/script/product-size.js"></script>
<script src="features/users/function/script/services-check.js"></script>
<script src="features/users/function/script/chatbot-toggle.js"></script>
<script src="features/users/function/script/scroll-choose_us.js"></script>
<script src="features/users/function/script/scroll-service.js"></script>
<script src="features/users/function/script/services-carousel.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
