<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization</title>
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
            <li><a class="dropdown-item" href="{{ route('profiles') }}">Profile Settings</a></li>
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
                    <a class="nav-link active" href="/organization">
                        <i class="bi bi-building me-2"></i> Organization
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account">
                        <i class="bi bi-building me-2"></i> Account Settings
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
           <h3 class="mb-3">Create Organization</h3>
           <hr>
        <div class="container-fluid">
            <div class="card shadow-sm p-4 mb-4">
             
                <p class="text-muted">Add your organization details to get started.</p>

                @if (session('status') === 'organization-submitted')
                    <div class="alert alert-success" role="alert">
                        Organization submitted and pending admin approval.
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.store') }}" class="mt-3">
                    @csrf

                    <div class="mb-3">
                        <label for="organization_name" class="form-label">Organization Name</label>
                        <input
                            type="text"
                            id="organization_name"
                            name="organization_name"
                            class="form-control @error('organization_name') is-invalid @enderror"
                            value="{{ old('organization_name') }}"
                            required
                        >
                        @error('organization_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input
                            type="text"
                            id="category"
                            name="category"
                            class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category') }}"
                            required
                        >
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input
                            type="text"
                            id="type"
                            name="type"
                            class="form-control @error('type') is-invalid @enderror"
                            value="{{ old('type') }}"
                            required
                        >
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address') }}"
                            required
                        >
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            class="form-control @error('contact_number') is-invalid @enderror"
                            value="{{ old('contact_number') }}"
                            required
                        >
                        @error('contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optional)</label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="4"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Organization</button>
                </form>
            </div>

            <div class="card shadow-sm p-4">
                <h4 class="mb-3">Your Organizations</h4>

                @forelse ($organizations as $organization)
                    <div class="border rounded p-3 mb-3 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="mb-0">{{ $organization->organization_name }}</h5>
                            @if (($organization->status ?? 'pending') === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending Approval</span>
                            @endif
                        </div>
                        <p class="mb-1"><strong>Category:</strong> {{ $organization->category }}</p>
                        <p class="mb-1"><strong>Type:</strong> {{ $organization->type }}</p>
                        <p class="mb-1"><strong>Address:</strong> {{ $organization->address }}</p>
                        <p class="mb-1"><strong>Contact Number:</strong> {{ $organization->contact_number }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $organization->email }}</p>
                        <p class="mb-0 text-muted">{{ $organization->description ?: 'No description provided.' }}</p>
                    </div>
                @empty
                    <p class="text-muted mb-0">You have not created an organization yet.</p>
                @endforelse
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
