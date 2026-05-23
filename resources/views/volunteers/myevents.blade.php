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
                    <a class="nav-link" href="/userdashboard">
                        <i class="bi bi-building me-2"></i> User Dashboard  
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link active" href="/myevents">
                        <i class="bi bi-building me-2"></i> My Events 
                    </a>
                </li>
               
        </div>
    </div>

    <main class="content-area">
         <h3 class="mb-3">My Created Events</h3>
         <hr>
        <div class="container-fluid">
        
            <div class="card shadow-sm p-4">
                
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

                @if($myEvents->count() > 0)
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
                                    <th>Approval</th>
                                    <th>Volunteers</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($event->description, 50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                        <td>{{ $event->start_time }} - {{ $event->end_time }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->organization ? $event->organization->organization_name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->status === 'upcoming' ? 'primary' : ($event->status === 'ongoing' ? 'success' : ($event->status === 'completed' ? 'secondary' : 'danger')) }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $event->approval_status === 'approved' ? 'success' : ($event->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($event->approval_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $event->volunteers->count() }} / {{ $event->required_volunteers }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3">
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#volunteersModal-{{ $event->id }}">
                                                    View Roster
                                                </button>
                                                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Edit</a>
                                                <form method="POST" action="{{ route('events.cancel', $event) }}" onsubmit="return confirm('Are you sure you want to cancel this event?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        You haven't created any events yet. <a href="{{ route('events.create') }}" class="alert-link">Create your first event</a>.
                    </div>
                @endif
            </div>
        </div>
    </main>

</div>

<!-- Volunteers Modals -->
@foreach($myEvents as $event)
<div class="modal fade" id="volunteersModal-{{ $event->id }}" tabindex="-1" aria-labelledby="volunteersModalLabel-{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="volunteersModalLabel-{{ $event->id }}">Volunteer Roster - {{ $event->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($event->volunteers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->volunteers as $volunteer)
                                    <tr>
                                        <td>{{ $volunteer->name }}</td>
                                        <td>{{ $volunteer->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <strong>Total Volunteers:</strong> {{ $event->volunteers->count() }} / {{ $event->required_volunteers }}
                    </div>
                @else
                    <p class="text-muted">No volunteers have joined this event yet.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>