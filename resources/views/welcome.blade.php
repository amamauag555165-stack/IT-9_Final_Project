<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASM Volunteer</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light px-3" style="background-color: #3676e0;">

    <!-- Brand -->
    <a class="navbar-brand text-white" href="#">
        <img src="{{ asset('images/volunteer_image.jpg') }}" width="30" height="30" class="rounded-circle me-2">
        ASM VOLUNTEER
    </a>

    <!-- Right Side -->
    <div class="ms-auto">

        @auth
            <!-- If logged in -->
            <a href="{{ url('/dashboard') }}" class="btn btn-light">
                Dashboard
            </a>
        @else
            <!-- If NOT logged in -->
            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">
                Login
            </a>

            <a href="{{ route('register') }}" class="btn btn-light">
                Register
            </a>
        @endauth

    </div>
</nav>

<!-- Carousel -->
<div class="container mt-4">

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner rounded-4 shadow">
            <div class="carousel-item active">
                <img src="{{ asset('images/vol6.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Together We Are Stronger</h2>
                    <p>Collaborate with like-minded individuals.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/vol4.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Change Lives</h2>
                    <p>Small actions lead to big changes.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/vol5.jpg') }}" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Make an Impact</h2>
                    <p>Join our community outreach programs today.</p>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</div>

<!-- CTA Button -->
<div class="container-fluid px-0 mt-4" id="joincontainer">
    <div class="row w-25 mx-auto mt-3">
        <a href="{{ route('login') }}" class="joinbutton text-white text-decoration-none text-center">
           <p class="mt-3">Volunteer Now</p>
        </a>
    </div>
</div>


<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Our Core Mission</h2>
                <p class="lead text-muted">The ASM Volunteer Management System is designed to bridge the gap between passionate individuals and community needs.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Streamlined event registration</li>
                    <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Simple volunteer registration</li>
                    <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Simple navigation and user-friendly</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/volunteer_image.jpg') }}" class="img-fluid rounded-circle shadow-lg" style="max-width: 300px;" alt="Mission">
            </div>
        </div>
    </div>
</section>

<footer class="py-5" style="background-color: #e3f2fd; border-top: 1px solid #dee2e6;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">ASM VOLUNTEER</h5>
                <p class="small mt-3 text-dark">Empowering communities through organized volunteerism and collective action. Join us in making the world a better place.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Privacy Policy</a></li>
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Terms of Service</a></li>
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Contact Support</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">Follow Us</h5>
                <div class="mt-3">
                    <a href="" class="text-primary me-3 fs-5"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="text-primary me-3 fs-5"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-primary me-3 fs-5"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr class="opacity-25" style="background-color: #0d6efd;">
        <div class="text-center small text-dark opacity-75 pb-2">
            &copy; {{ date('Y') }} ASM Volunteer Management System. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>