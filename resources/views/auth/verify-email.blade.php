<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | ASM Volunteer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --brand-blue: #7cabf9;
            --success-green: #2e7d32;
            --light-green: #e8f5e9;
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
            overflow-y: auto;
            padding: 2rem 0;
        }

        /* The floating card */
        .verification-card {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin: 2rem auto;
        }

        .card-header {
            margin-bottom: 1rem;
        }

        .card-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 0.95rem;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .verification-icon {
            width: 60px;
            height: 60px;
            background-color: var(--light-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--success-green);
        }

        .alert-success-custom {
            background-color: var(--light-green);
            border: 1px solid #a5d6a7;
            border-radius: 15px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--success-green);
            font-size: 0.9rem;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-success-custom::before {
            content: '✓';
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        .btn-resend {
            background-color: var(--brand-blue);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-resend:hover {
            background-color: #5a9de0;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 171, 249, 0.3);
        }

        .btn-resend:active {
            transform: translateY(0);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-logout {
            background-color: transparent;
            border: 2px solid var(--brand-blue);
            border-radius: 50px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            color: var(--brand-blue);
            transition: all 0.3s ease;
            width: 100%;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: var(--brand-blue);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 171, 249, 0.3);
        }

        .btn-logout:active {
            transform: translateY(0);
        }

        .email-highlight {
            font-weight: 600;
            color: var(--brand-blue);
        }

        .instruction-text {
            background-color: #f8f9fa;
            border-left: 4px solid var(--brand-blue);
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Responsive: Stack on small screens */
        @media (max-width: 992px) {
            .illustration-section { display: none; }
            .blue-panel-section { border-radius: 0; }
            .verification-card { margin: 20px; }
            .full-screen-wrapper { height: auto; min-height: 100vh; }
            .button-group {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .verification-card {
                padding: 2rem;
            }

            .card-header h2 {
                font-size: 1.5rem;
            }

            .card-description {
                font-size: 0.9rem;
            }
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
            <div class="verification-card">
                <!-- Icon -->
                <div class="verification-icon">
                    ✉️
                </div>

                <!-- Header -->
                <div class="card-header">
                    <h2>Verify Your Email</h2>
                </div>

                <!-- Main Description -->
                <p class="card-description">
                    Thanks for signing up! We've sent a verification link to your email. Please check your inbox and click the link to activate your account.
                </p>

                <!-- Success Alert (if link was resent) -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert-success-custom">
                        <div>A new verification link has been sent to your email address. Please check your inbox and spam folder.</div>
                    </div>
                @endif

                <!-- Instruction Box -->
                <div class="instruction-text">
                    <strong>What's next?</strong><br>
                    Check your email for our verification link. If you don't see it in a few minutes, check your spam or junk folder.
                </div>

                <!-- Button Group -->
                <div class="button-group">
                    <!-- Resend Verification Email Form -->
                    <form method="POST" action="{{ route('verification.send') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-resend">
                            Resend Verification Email
                        </button>
                    </form>

                    <!-- Log Out Form -->
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            Log Out
                        </button>
                    </form>
                </div>

                <!-- Help Text -->
                <p class="text-center mt-4" style="font-size: 0.85rem; color: #999;">
                    Having trouble? <a href="#" class="text-decoration-none" style="color: var(--brand-blue); font-weight: 600;">Contact support</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>