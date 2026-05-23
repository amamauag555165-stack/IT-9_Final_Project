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
                    <a class="nav-link" href="/account">
                        <i class="bi bi-gear me-2"></i> Account Settings
                    </a>
                </li>
            </ul>
               <hr>
               <li class="nav-item">
                    <a class="nav-link active" href="/userdashboard">
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

        <div class="container-fluid">
                <p class="fw-bold fs-3">Hi, {{ Auth::user()->name }}</p>
            <hr>

            <!-- Stats Section -->
          <div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border bg-white">
            <div class="card-body text-white">
                <h6 class="card-title mb-2 text-muted">Total Hours Worked</h6>
                <h2 class="mb-0 fw-bold text-dark">{{ $totalHours ?? 0 }}</h2>
                <small class="text-muted">Hours</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border bg-white">
            <div class="card-body text-white">
                <h6 class="card-title mb-2 text-muted">Events Attended</h6>
                <h2 class="mb-0 fw-bold text-dark">{{ $joinedEvents->count() + $completedEvents->count() }}</h2>
                <small class="text-muted">Events</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border bg-white">
            <div class="card-body text-white">
                <h6 class="card-title mb-2 text-muted">Completed Events</h6>
                <h2 class="mb-0 fw-bold text-dark">{{ $completedEvents->count() }}</h2>
                <small class="text-muted">Events</small>
            </div>
        </div>
    </div>
</div>

            <div class="card shadow-sm p-4 mb-4">
                <h4 class="mb-4">My Joined Events</h4>
                
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

                @if($joinedEvents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Event Title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Organization</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($joinedEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($event->description, 50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                        <td>{{ $event->start_time }} - {{ $event->end_time }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->organization ? $event->organization->name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->status === 'upcoming' ? 'primary' : ($event->status === 'ongoing' ? 'success' : ($event->status === 'completed' ? 'secondary' : 'danger')) }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('events.leave', $event) }}" onsubmit="return confirm('Are you sure you want to leave this event?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Leave</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        You haven't joined any events yet. <a href="{{ route('events') }}" class="alert-link">Browse available events</a>.
                    </div>
                @endif
            </div>

            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Event History (Completed)</h4>
                
                @if($completedEvents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Event Title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Organization</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($completedEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($event->description, 50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                        <td>{{ $event->start_time }} - {{ $event->end_time }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->organization ? $event->organization->name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                Completed
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No completed events in your history yet.
                    </div>
                @endif
            </div>
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>