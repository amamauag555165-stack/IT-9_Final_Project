<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
      <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>

<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light px-3 " style="background-color: #3676e0;">

    <!-- Brand -->
    <a class="navbar-brand text-white" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/volunteer_image.jpg') }}" width="30" height="30" class="rounded-circle me-2" alt="">
        ASM VOLUNTEER
    </a>

    <!-- Right Side Dropdown -->
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

<!-- Main Content -->
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4 mb-4 text-white" style="background-color: #2c7ec2; border-radius: 16px;">
        <div>
            <h2 class="fw-bold mb-1"><i></i>Events</h2>
            <p class="mb-0 opacity-75 small">Discover volunteer opportunities in your community</p>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-light fw-semibold" style="border-radius: 10px;">
            <i class="fas fa-plus me-1 text-primary"></i> Create Event
        </a>
    </div>

    <!-- Search Filter Form -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
        <div class="card-header bg-white border-bottom" style="border-radius: 14px 14px 0 0; padding: 1rem 1.5rem;">
            <span class="fw-bold text-primary"><i class="fas fa-sliders-h me-2"></i>Find Events</span>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('events') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="organization" class="form-label small fw-semibold text-muted">Organization</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-building small"></i></span>
                            <select class="form-select border-start-0 ps-0" id="organization" name="organization" style="background-color: #f8f9fa;">
                                <option value="">All Organizations</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}" {{ request('organization') == $org->id ? 'selected' : '' }}>
                                        {{ $org->organization_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="location" class="form-label small fw-semibold text-muted">Location</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-map-marker-alt small"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="location" name="location" value="{{ request('location') }}" placeholder="Search by location" style="background-color: #f8f9fa;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label small fw-semibold text-muted">Schedule Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-calendar-alt small"></i></span>
                            <input type="date" class="form-control border-start-0 ps-0" id="date" name="date" value="{{ request('date') }}" style="background-color: #f8f9fa;">
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('events') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

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

    @if($events->count() > 0)
<div class="row">
    @foreach($events as $event)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow hover-shadow transition overflow-hidden" style="border-radius: 16px; transition: transform 0.25s ease, box-shadow 0.25s ease;">
            <!-- Status Badge (Absolute Positioned) -->
            <div class="position-absolute top-0 end-0 m-3" style="pointer-events: none; z-index: 2;">
                <span class="badge rounded-pill bg-{{ $event->status === 'upcoming' ? 'primary' : ($event->status === 'ongoing' ? 'success' : ($event->status === 'completed' ? 'secondary' : 'danger')) }} shadow-sm" style="font-size: 0.75rem; padding: 0.5em 0.9em;">
                    {{ ucfirst($event->status) }}
                </span>
            </div>

            <a href="{{ route('events.show', $event) }}" class="text-decoration-none d-block">
                <div class="overflow-hidden" style="height: 200px;">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top w-100 h-100" alt="{{ $event->title }}" style="object-fit: cover; transition: transform 0.4s ease;">
                    @else
                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                            <span class="text-muted"><i class="fas fa-image me-2"></i>No Image</span>
                        </div>
                    @endif
                </div>
            </a>

            <div class="card-body d-flex flex-column p-4">
                <a href="{{ route('events.show', $event) }}" class="text-decoration-none">
                    <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.15rem; line-height: 1.4;">{{ $event->title }}</h5>
                </a>

                    @if($event->organization)
                        <div class="d-flex align-items-center text-primary small mb-3 fw-semibold">
                            <i class="fas fa-building me-2 opacity-75"></i>{{ $event->organization->organization_name }}
                        </div>
                    @endif

                    <p class="card-text text-muted small mb-3" style="line-height: 1.5;">
                        {{ Str::limit($event->description, 90) }}
                    </p>

                    <!-- Event Details Grid -->
                    <div class="mt-auto">
                        <div class="d-flex align-items-center mb-2 small text-secondary">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; border-radius: 8px;">
                                <i class="fas fa-calendar-alt" style="font-size: 0.7rem;"></i>
                            </div>
                            <span>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 small text-secondary">
                            <div class="icon-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; border-radius: 8px;">
                                <i class="fas fa-clock" style="font-size: 0.7rem;"></i>
                            </div>
                            <span>{{ $event->start_time }} - {{ $event->end_time }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 small text-secondary">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; border-radius: 8px;">
                                <i class="fas fa-map-marker-alt" style="font-size: 0.7rem;"></i>
                            </div>
                            <span class="text-truncate">{{ $event->location }}</span>
                        </div>

                        <!-- Volunteer Progress -->
                        <div class="mb-3 pt-2">
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="fw-semibold text-dark"><i class="fas fa-users me-1 text-info"></i>Volunteers</span>
                            <span class="fw-bold text-dark">{{ $event->volunteers->count() }} / {{ $event->required_volunteers }}</span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 4px;">
                            @php
                                $percentage = min(100, ($event->volunteers->count() / $event->required_volunteers) * 100);
                            @endphp
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%; border-radius: 4px;"></div>
                        </div>

                        @if($event->created_by == auth()->id() && $event->volunteers->count() > 0)
                            <div class="mt-2">
                                <button class="btn btn-sm btn-link p-0 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#volunteers-{{ $event->id }}">
                                    <small class="fw-bold">View Volunteers ({{ $event->volunteers->count() }})</small>
                                </button>
                                <div class="collapse mt-2" id="volunteers-{{ $event->id }}">
                                    <div class="bg-light rounded p-2">
                                        @foreach($event->volunteers as $volunteer)
                                            <div class="d-flex align-items-center mb-1">
                                                <small class="text-dark">{{ $volunteer->name }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Announcements Section (Collapsed or scrollable) -->
                @if($event->announcements->count() > 0)
                    <div class="bg-light p-3 rounded-3 mb-3" style="max-height: 120px; overflow-y: auto;">
                        <small class="fw-bold d-block mb-2 text-uppercase text-muted" style="font-size: 0.65rem; letter-spacing: 0.5px;"><i class="fas fa-bullhorn me-1"></i>Announcements</small>
                        @foreach($event->announcements as $announcement)
                            <div class="d-flex align-items-start mb-2">
                                <div class="bg-info rounded-circle me-2 mt-1 flex-shrink-0" style="width: 6px; height: 6px;"></div>
                                <p class="mb-0 small text-secondary" style="font-size: 0.8rem; line-height: 1.4;">{{ $announcement->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-grid gap-2 mt-2">
                    @if($event->created_by == auth()->id())
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-primary btn-sm rounded-3 fw-semibold"><i class="fas fa-edit me-1"></i>Edit Event Details</a>
                        <form method="POST" action="{{ route('events.cancel', $event) }}" onsubmit="return confirm('Are you sure you want to cancel this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-3 fw-semibold"><i class="fas fa-trash-alt me-1"></i>Cancel Event</button>
                        </form>
                    @else
                        @if($event->volunteers->contains(auth()->id()))
                            <button class="btn btn-success w-100 rounded-3 fw-semibold" disabled>
                                <i class="fas fa-check-circle me-1"></i> You've Joined
                            </button>
                        @elseif($event->volunteers->count() >= $event->required_volunteers)
                            <button class="btn btn-secondary w-100 rounded-3 fw-semibold" disabled><i class="fas fa-lock me-1"></i>Event Full</button>
                        @else
                            <button type="button" class="btn btn-primary w-100 shadow-sm rounded-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#joinModal-{{ $event->id }}"><i class="fas fa-hand-holding-heart me-1"></i>Join Event</button>

                            <!-- Join Confirmation Modal -->
                            <div class="modal fade" id="joinModal-{{ $event->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 16px; border: none;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-primary"><i class="fas fa-hand-holding-heart me-2"></i>Confirm Attendance</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pt-3">
                                            <p class="text-muted mb-0" style="line-height: 1.6;">
                                                Before you click <strong>"I will attend"</strong> please note that clicking this button means you will be given a slot for this volunteer opportunity. We've prepared this event so you could have a great time volunteering. We are really counting on you to show up!
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('events.join', $event) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4">I will attend</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $events->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
@endif
</div>
<footer class="py-5" style="background-color: #e3f2fd; border-top: 1px solid #dee2e6;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">ASM VOLUNTEER</h5>
                <p class="small mt-3 text-dark">Empowering communities through organized volunteerism and collective action. Join us in making the world a better place.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Privacy Policy</a></li>
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Terms of Service</a></li>
                    <li><a href="#" class="text-decoration-none text-dark small opacity-75">Contact Support</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-primary fw-bold">Follow Us</h5>
                <div class="mt-3">
                    <a href="https://www.facebook.com/arthur.mamauag" class="text-primary me-3 fs-5"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/babaevartor/?hl=en" class="text-primary me-3 fs-5"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-primary me-3 fs-5"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr class="opacity-25" style="background-color: #0d6efd;">
        <div class="text-center small text-dark opacity-75 pb-2">
            &copy; {{ date('Y') }} ASM Volunteer Management System. All rights reserved.
        </div>
    </div>
</footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>