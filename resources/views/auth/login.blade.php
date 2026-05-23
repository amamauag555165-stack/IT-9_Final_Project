<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ASM Volunteer</title>
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
            overflow-x: hidden;
        }

        /* The main wrapper filling the screen */
        .full-screen-wrapper {
            height: 100vh;
            display: flex;
        }

        /* Left side: Illustration */
        .illustration-section {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .illustration-section img {
            max-width: 80%;
            height: auto;
        }

        /* Right side: Blue container */
        .blue-panel-section {
            background-color: var(--brand-blue);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            /* Curved edge on the left like the image */
            border-top-left-radius: 40px;
            border-bottom-left-radius: 40px;
        }

        /* The floating card */
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .form-control {
            border-radius: 50px; /* Pill shape like the image */
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fa;
            border: 1px solid #eee;
        }

        .btn-volunteer {
            background-color: var(--brand-blue);
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        /* Responsive: Stack on small screens */
        @media (max-width: 992px) {
            .illustration-section { display: none; }
            .blue-panel-section { border-radius: 0; }
            .login-card { margin: 20px; }
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

    
    
    <!-- Left Side -->
    <div class="illustration-section d-none d-lg-flex flex-column">
        <!-- Replace with your actual illustration path -->
        <img src="{{ asset('images/volunteer_image.jpg') }}" alt="Illustration">
        <p class="text-center text-muted mt-4 px-5 fst-italic" style="font-size: 1.05rem; max-width: 500px;">
            "Together, we can change the world — one volunteer at a time."
        </p>
    </div>

    <!-- Right Side -->
    <div class="blue-panel-section">
        <div class="login-card">
            <h2 class="fw-bold mb-1">Hello!</h2>
            <p class="text-muted mb-4">Log in to Get Started</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email Address"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password"
                           required autocomplete="current-password">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-volunteer">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">Forgot Password?</a>
                @endif
                <p class="text-muted small mt-2">
                    New? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Create account</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>