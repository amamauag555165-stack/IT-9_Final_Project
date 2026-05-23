<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

       .sidebar {
    width: 260px;
    background: #0f172a; /* Solid deep navy */
    color: white;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100%;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}

.sidebar-header {
    padding: 30px 20px;
    text-align: left;
    background: #0f172a;
    font-size: 1.4rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: #f8fafc;
    border-bottom: 1px solid #1e293b;
}

.sidebar-menu {
    list-style: none;
    padding: 15px 0;
    margin: 0;
    flex-grow: 1;
}

.sidebar-menu li {
    position: relative;
    margin: 4px 12px; /* Adds breathing room around the links */
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #94a3b8; /* Muted text */
    text-decoration: none;
    font-weight: 500;
    border-radius: 8px; /* Rounded pill look for hover */
    transition: all 0.2s ease-in-out;
}

/* Hover State */
.sidebar-menu a:hover {
    background: #1e293b;
    color: #3b82f6; /* Blue text highlight */
}

/* Active State Logic (Laravel Helper) */
.sidebar-menu li.active a {
    background: #1e293b;
    color: white;
}

/* Vertical indicator for active/hover */
.sidebar-menu li.active::before {
    content: "";
    position: absolute;
    left: -12px; /* Align to edge of sidebar */
    top: 10px;
    bottom: 10px;
    width: 4px;
    background: #3b82f6;
    border-radius: 0 4px 4px 0;
}

.logout-section {
    padding: 20px;
    border-top: 1px solid #1e293b;
}

.btn-logout {
    width: 100%;
    padding: 12px;
    background: #1e293b;
    color: #f87171; /* Subtle red */
    border: 1px solid #334155;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-logout:hover {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
}

        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: white;
            color: #1e293b;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .container { padding: 30px; }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .btn-logout {
            width: 100%;
            padding: 10px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-logout:hover { background: #dc2626; }

        .filter-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-row a {
            text-decoration: none;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            background: #fff;
        }

        .filter-row a.active {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        .status-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .btn {
            padding: 8px 12px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-approve { background: #16a34a; }
        .btn-reject { background: #f59e0b; color: #111827; }
        .btn-delete { background: #dc2626; }

        .event-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .events-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .events-container::-webkit-scrollbar {
            width: 8px;
        }

        .events-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .events-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .events-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        Admin Portal
    </div>
    
    <ul class="sidebar-menu">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <a href="{{ route('admin.events.index') }}">
                Manage Events
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.organizations.index') }}">
                Manage Organizations
            </a>
        </li>
    </ul>
    
    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="navbar">
        <strong>Welcome, Admin</strong>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #22c55e;">
                <p style="margin: 0;">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <p style="margin: 0;">{{ session('error') }}</p>
            </div>
        @endif

        <div class="card">
            <h3>Manage Events</h3>
            <p>Review submitted events and update their approval status.</p>

            <div class="filter-row">
                <a href="{{ route('admin.events.index') }}" class="{{ $statusFilter === '' ? 'active' : '' }}">All</a>
                <a href="{{ route('admin.events.index', ['status' => 'pending']) }}" class="{{ $statusFilter === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.events.index', ['status' => 'approved']) }}" class="{{ $statusFilter === 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('admin.events.index', ['status' => 'rejected']) }}" class="{{ $statusFilter === 'rejected' ? 'active' : '' }}">Rejected</a>
            </div>

            <div class="events-container">
                @forelse ($events as $event)
                <div class="event-card">
                    <div style="display:flex;justify-content:space-between;gap:10px;align-items:start;">
                        <strong>{{ $event->title }}</strong>
                        <span class="status-badge status-{{ $event->approval_status ?? 'pending' }}">
                            {{ $event->approval_status ?? 'pending' }}
                        </span>
                    </div>
                    <p style="margin: 10px 0 6px;">{{ $event->description }}</p>
                    <small style="display:block; line-height:1.6;">
                        Date: {{ $event->event_date }}<br>
                        Time: {{ $event->start_time }} - {{ $event->end_time }}<br>
                        Location: {{ $event->location }}<br>
                        Required Volunteers: {{ $event->required_volunteers }}<br>
                        Status: {{ $event->status }}<br>
                        Organization: {{ $event->organization?->organization_name ?? 'N/A' }}<br>
                        Created by: {{ $event->creator?->name ?? 'N/A' }}
                    </small>

                    <div class="actions">
                        @if (($event->approval_status ?? 'pending') !== 'approved')
                            <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-approve">Approve</button>
                            </form>
                        @endif

                        @if (($event->approval_status ?? 'pending') !== 'rejected')
                            <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-reject">Reject</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No events found for this filter.</p>
            @endforelse
            </div>
        </div>
    </div>
</div>

</body>
</html>
