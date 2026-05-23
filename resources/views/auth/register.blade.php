<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ASM Volunteer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --brand-blue: #7cabf9;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Container that fills the entire viewport */
        .full-screen-wrapper {
            height: 100vh;
            display: flex;
        }

        /* Left Side: White space for illustration */
        .illustration-section {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .illustration-section img {
            max-width: 70%;
            height: auto;
        }

        /* Right Side: Large Blue Rounded Panel */
        .blue-panel-section {
            background-color: var(--brand-blue);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top-left-radius: 40px;
            border-bottom-left-radius: 40px;
        }

        /* Floating Registration Card */
        .register-card {
            background: #ffffff;
            width: 100%;
            max-width: 480px; /* Slightly wider for side-by-side password fields */
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Pill-shaped Inputs to match image_576f96.png */
        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.1);
        }

        /* Brand Button */
        .btn-volunteer {
            background-color: var(--brand-blue);
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            margin-top: 1rem;
            transition: transform 0.2s ease;
        }

        .btn-volunteer:hover {
            background-color: #0069d9;
            transform: translateY(-1px);
        }

        /* Mobile Adjustment */
        @media (max-width: 992px) {
            .illustration-section { display: none; }
            .blue-panel-section { border-radius: 0; }
            .register-card { margin: 1.5rem; padding: 2rem; }
        }
    </style>
</head>
<body>
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

<div class="full-screen-wrapper">
    
    <!-- Left Section (Illustration) -->
    <div class="illustration-section d-none d-lg-flex flex-column">
        <img src="{{ asset('images/volunteer_image.jpg') }}" alt="Registration Illustration">
        <p class="text-center text-muted mt-4 px-5 fst-italic" style="font-size: 1.05rem; max-width: 500px;">
            "Together, we can change the world — one volunteer at a time."
        </p>
    </div>

    <!-- Right Section (Blue Panel) -->
    <div class="blue-panel-section">
        <div class="register-card">
            <h2 class="fw-bold mb-1">Join Us!</h2>
            <p class="text-muted mb-4">Create an account to get started</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Full Name"
                           value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback ps-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email Address"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback ps-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" placeholder="Confirm" required>
                    </div>
                    @error('password')
                        <div class="col-12 mt-n2 mb-3 text-danger small ps-3">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-volunteer">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-muted small">
                    Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>