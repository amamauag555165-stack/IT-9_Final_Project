<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex; /* Establish flex layout for sidebar + content */
            min-height: 100vh;
        }

        /* --- SIDEBAR STYLES --- */
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

        /* --- MAIN CONTENT STYLES --- */
        .main-content {
            margin-left: 260px; /* Push content to the right of sidebar */
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: white;
            color: #1e293b;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end; /* Align header items to right */
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .container { padding: 30px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .active-events-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .active-events-container::-webkit-scrollbar {
            width: 8px;
        }

        .active-events-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .active-events-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .active-events-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2563eb;
            margin: 10px 0;
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
        @if (session('status') === 'organization-approved')
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #22c55e;">
                <p style="margin: 0;">Organization approved successfully.</p>
            </div>
        @endif

        <div class="stats-grid">
            <div class="card">
                <h4>Total Users</h4>
                <p class="stat-number">{{ $userCount ?? '0' }}</p>
                <small>Registered members</small>
            </div>
            
            <div class="card">
                <h4>Active Events</h4>
                <p class="stat-number">{{ $eventCount ?? '0' }}</p>
                <small>Upcoming schedules</small>
            </div>

             <div class="card">
                <h4>Pending Events</h4>
                <p class="stat-number">{{ $pendingEventCount ?? '0' }}</p>
                <small>Awaiting approval</small>
            </div>
        </div>

        <div class="content-grid">
            <div>
                <div class="card" style="margin-bottom: 20px;">
                    <h3>Pending Organizations</h3>
                    @forelse ($pendingOrganizations as $organization)
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                            <strong>{{ $organization->organization_name }}</strong>
                            <p style="margin: 8px 0;">{{ $organization->description ?: 'No description provided.' }}</p>
                            <small style="display: block; margin-bottom: 10px;">
                                Category: {{ $organization->category }} |
                                Type: {{ $organization->type }} |
                                Address: {{ $organization->address }} |
                                Contact: {{ $organization->contact_number }} |
                                Email: {{ $organization->email }}
                            </small>
                            <form method="POST" action="{{ route('admin.organizations.approve', $organization) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="padding: 8px 12px; background: #2563eb; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                                    Approve Organization
                                </button>
                            </form>
                        </div>
                    @empty
                        <p>No pending organizations at the moment.</p>
                    @endforelse
                </div>

                <div class="card">
                    <h3>Pending Events</h3>
                    @forelse ($pendingEvents as $event)
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                            <strong>{{ $event->title }}</strong>
                            <p style="margin: 8px 0;">{{ $event->description ?: 'No description provided.' }}</p>
                            <small style="display: block; margin-bottom: 10px;">
                                Date: {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }} |
                                Time: {{ $event->start_time }} - {{ $event->end_time }} |
                                Location: {{ $event->location }} |
                                @if($event->organization)
                                    Organization: {{ $event->organization->organization_name }}
                                @endif
                            </small>
                            <div style="display: flex; gap: 10px;">
                                <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="padding: 8px 12px; background: #22c55e; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                                        Approve Event
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="padding: 8px 12px; background: #ef4444; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                                        Reject Event
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No pending events at the moment.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h3>Active Events</h3>
                <div class="active-events-container">
                    @if($activeEvents->count() > 0)
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                <thead>
                                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Event Title</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Date</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Time</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Location</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Organization</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Status</th>
                                        <th style="padding: 12px; text-align: left; font-weight: 600;">Volunteers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeEvents as $event)
                                        <tr style="border-bottom: 1px solid #e2e8f0;">
                                            <td style="padding: 12px;">{{ $event->title }}</td>
                                            <td style="padding: 12px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                            <td style="padding: 12px;">{{ $event->start_time }} - {{ $event->end_time }}</td>
                                            <td style="padding: 12px;">{{ $event->location }}</td>
                                            <td style="padding: 12px;">{{ $event->organization ? $event->organization->organization_name : 'N/A' }}</td>
                                            <td style="padding: 12px;">
                                                <span style="padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; background: {{ $event->status === 'upcoming' ? '#dcfce7; color: #166534;' : '#dbeafe; color: #1e40af;' }}">
                                                    {{ $event->status }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px;">{{ $event->volunteers->count() }} / {{ $event->required_volunteers }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p style="margin-top: 15px;">No active events at the moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>