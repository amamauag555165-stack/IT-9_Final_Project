<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ASM Volunteer</title>
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
            flex-direction: column;
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
            border-top-left-radius: 40px;
            border-bottom-left-radius: 40px;
        }

        /* The floating card */
        .password-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            background-color: #f8f9fa;
            border: 1px solid #eee;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 0.2rem rgba(124, 171, 249, 0.25);
            background-color: #ffffff;
        }

        .btn-reset {
            background-color: var(--brand-blue);
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            margin-top: 1.5rem;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .btn-reset:hover {
            background-color: #5a9de0;
            color: #ffffff;
        }

        .btn-reset:active {
            transform: scale(0.98);
        }

        .card-header {
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-to-login a {
            color: var(--brand-blue);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-to-login a:hover {
            color: #5a9de0;
            text-decoration: underline;
        }

        .alert {
            border-radius: 15px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .error-message {
            color: #d32f2f;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Responsive: Stack on small screens */
        @media (max-width: 992px) {
            .illustration-section { display: none; }
            .blue-panel-section { border-radius: 0; }
            .password-card { margin: 20px; }
            .full-screen-wrapper { height: auto; min-height: 100vh; }
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
        <div class="illustration-section d-none d-lg-flex">
            <img src="{{ asset('images/volunteer_image.jpg') }}" alt="Illustration">
            <p class="text-center text-muted mt-4 px-5 fst-italic" style="font-size: 1.05rem; max-width: 500px;">
                "Together, we can change the world — one volunteer at a time."
            </p>
        </div>

        <!-- Right Side -->
        <div class="blue-panel-section">
            <div class="password-card">
                <div class="card-header">
                    <h2 class="fw-bold mb-0">Reset Password</h2>
                </div>
                
                <p class="card-description">
                    No problem! Just let us know your email address and we'll send you a password reset link.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Email Address"
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        
                        @error('email')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-reset">
                            Send Reset Link
                        </button>
                    </div>
                </form>

                <div class="back-to-login">
                    <a href="{{ route('login') }}" class="small">
                        ← Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>