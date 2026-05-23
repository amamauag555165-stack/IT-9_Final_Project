<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            min-height: calc(100vh - 56px);
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
                    <a class="nav-link" href="/profile">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/organization">
                        <i class="bi bi-building me-2"></i> Organization
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/account">
                        <i class="bi bi-gear me-2"></i> Account Settings
                    </a>
                <hr>
                </li>
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
            </ul>
        </div>
    </div>

    <main class="content-area">
         <h3 class="mb-3">Account Settings</h3>
         <hr>
        <div class="container-fluid">
           

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Change Password</h5>
                    
                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password" 
                                   name="new_password" 
                                   required
                                   minlength="8">
                            <div class="form-text">Password must be at least 8 characters long.</div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   required
                                   minlength="8">
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Account Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" 
                               class="form-control" 
                               value="{{ Auth::user()->name }}" 
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               class="form-control" 
                               value="{{ Auth::user()->email }}" 
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Type</label>
                        <input type="text" 
                               class="form-control" 
                               value="{{ Auth::user()->is_admin ? 'Admin' : 'User' }}" 
                               disabled>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>