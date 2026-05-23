<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            min-height: calc(100vh - 56px); /* Full height minus navbar */
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 15px 20px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: #3676e0;
        }

        .sidebar .nav-link.active {
            background-color: #eef4ff;
            color: #3676e0;
            border-left-color: #3676e0;
        }

        /* Adjust content layout */
        .main-wrapper {
            display: flex;
        }

        .content-area {
            flex-grow: 1;
            padding: 30px;
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark px-3 shadow-sm" style="background-color: #3676e0;">
    <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/volunteer_image.jpg') }}" width="30" height="30" class="rounded-circle me-2" alt="Logo">
        <span>ASM VOLUNTEER</span>
    </a>

    <div class="ms-auto dropdown">
        <button class="btn dropdown-toggle text-white border-0" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            {{ Auth::user()->name }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="#">Profile Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div class="main-wrapper">
    <div class="sidebar d-none d-md-block">
        <div class="py-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/profile">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/organization">
                        <i class="bi bi-building me-2"></i> Organization
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account">
                        <i class="bi bi-gear me-2"></i> Account Settings
                    </a>
                </li>
            </ul>
               <hr>
               <li class="nav-item">
                    <a class="nav-link" href="/userdashboard">
                        <i class="bi bi-building me-2"></i> User Dashboard  
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="/myevents">
                        <i class="bi bi-building me-2"></i> My Events 
                    </a>
                </li>
               
        </div>
    </div>

    
    <main class="content-area">
        <h3 class="mb-4">Profile Information</h3>
        <hr>
        <div class="container-fluid">
            <div class="card shadow-sm p-4">

                <p class="text-muted">Update your account details below.</p>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success" role="alert">
                        Profile updated successfully.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="mt-3">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name ?? Auth::user()->name) }}"
                            required
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email ?? Auth::user()->email) }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>