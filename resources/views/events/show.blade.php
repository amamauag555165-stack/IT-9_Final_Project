<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Event Details</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .event-header {
            background: #667eea;
            color: white;
            padding: 40px 0;
        }
        .event-image {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px;
        }
        .info-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 20px;
        }
        .badge-status {
            font-size: 1rem;
            padding: 8px 16px;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light px-3 shadow-sm" style="background-color: #3676e0;">
    <a class="navbar-brand text-white" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/volunteer_image.jpg') }}" width="30" height="30" class="rounded-circle me-2" alt="">
        ASM VOLUNTEER
    </a>

    <div class="ms-auto dropdown">
        <button class="btn dropdown-toggle text-white border-0" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
            {{ Auth::user()->name }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ route('profiles')}}">
                    Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<!-- Event Header -->
<div class="event-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge rounded-pill bg-{{ $event->status === 'upcoming' ? 'primary' : ($event->status === 'ongoing' ? 'success' : ($event->status === 'completed' ? 'secondary' : 'danger')) }} badge-status mb-2">
                    {{ ucfirst($event->status) }}
                </span>
                <h1 class="fw-bold">{{ $event->title }}</h1>
            </div>
            <a href="{{ route('events') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Back to Events
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Event Details -->
        <div class="col-lg-8">
            <!-- Event Image -->
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="event-image mb-4" alt="{{ $event->title }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center event-image mb-4" style="background: #e9ecef;">
                    <span class="text-muted">No Image</span>
                </div>
            @endif

            <!-- Description -->
            <div class="info-card">
                <h4 class="mb-3">About This Event</h4>
                <p class="text-muted">{{ $event->description }}</p>
            </div>

            <!-- Event Details -->
            <div class="info-card">
                <h4 class="mb-3">Event Details</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong><i class="bi bi-calendar-event me-2"></i>Date:</strong>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong><i class="bi bi-clock me-2"></i>Time:</strong>
                        <p class="mb-0">{{ $event->start_time }} - {{ $event->end_time }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong><i class="bi bi-geo-alt me-2"></i>Location:</strong>
                        <p class="mb-0">{{ $event->location }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong><i class="bi bi-people me-2"></i>Volunteers Needed:</strong>
                        <p class="mb-0">{{ $event->volunteers->count() }} / {{ $event->required_volunteers }}</p>
                    </div>
                </div>
            </div>

            <!-- Organization -->
            @if($event->organization)
                <div class="info-card">
                    <h4 class="mb-3">Organization</h4>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $event->organization->organization_name }}</h5>
                            <p class="text-muted mb-0">{{ $event->organization->category }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Announcements -->
            @if($event->announcements->count() > 0)
                <div class="info-card">
                    <h4 class="mb-3">Announcements</h4>
                    @foreach($event->announcements as $announcement)
                        <div class="border-start border-4 border-info ps-3 mb-3">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y - g:i A') }}</small>
                            <p class="mb-0 mt-1">{{ $announcement->message }}</p>
                            <small class="text-muted">Posted by {{ $announcement->user->name }}</small>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column - Actions -->
        <div class="col-lg-4">
            <!-- Join/Leave Button -->
            <div class="info-card">
                <h4 class="mb-3">Take Action</h4>
                @if($event->created_by == auth()->id())
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-primary w-100 mb-2">Edit Event</a>
                    <form method="POST" action="{{ route('events.cancel', $event) }}" onsubmit="return confirm('Are you sure you want to cancel this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Cancel Event</button>
                    </form>
                @else
                    @if($event->volunteers->contains(auth()->id()))
                        <button class="btn btn-success w-100 mb-2" disabled>
                            <i class="bi bi-check-circle me-1"></i> You've Joined
                        </button>
                        <form method="POST" action="{{ route('events.leave', $event) }}" onsubmit="return confirm('Are you sure you want to leave this event?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Leave Event</button>
                        </form>
                    @elseif($event->volunteers->count() >= $event->required_volunteers)
                        <button class="btn btn-secondary w-100" disabled>Event Full</button>
                    @else
                        <form method="POST" action="{{ route('events.join', $event) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">Join Event</button>
                        </form>
                    @endif
                @endif
            </div>

            <!-- Volunteer Progress -->
            <div class="info-card">
                <h4 class="mb-3">Volunteer Progress</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $event->volunteers->count() }} joined</span>
                    <span>{{ $event->required_volunteers }} needed</span>
                </div>
                <div class="progress" style="height: 10px;">
                    @php
                        $percentage = ($event->volunteers->count() / $event->required_volunteers) * 100;
                    @endphp
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%"></div>
                </div>
                <small class="text-muted mt-2 d-block">{{ round($percentage, 1) }}% filled</small>
            </div>

            <!-- Add Announcement (for organizers) -->
            @if($event->created_by == auth()->id())
                <div class="info-card">
                    <h4 class="mb-3">Post Announcement</h4>
                    <form method="POST" action="{{ route('events.announcements.create', $event) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="3" placeholder="Write an announcement..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-info w-100">Post Announcement</button>
                    </form>
                </div>
            @endif

            <!-- Volunteers List -->
            @if($event->volunteers->count() > 0)
                <div class="info-card">
                    <h4 class="mb-3">Volunteers ({{ $event->volunteers->count() }})</h4>
                    <div class="list-group list-group-flush">
                        @foreach($event->volunteers as $volunteer)
                            <div class="list-group-item d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($volunteer->name, 0, 1)) }}
                                </div>
                                <span>{{ $volunteer->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
