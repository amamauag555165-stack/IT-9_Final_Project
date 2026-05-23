<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Organizations</title>

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

        .org-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .orgs-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .orgs-container::-webkit-scrollbar {
            width: 8px;
        }

        .orgs-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .orgs-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .orgs-container::-webkit-scrollbar-thumb:hover {
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
        @if (session('status') === 'organization-approved')
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #22c55e;">
                <p style="margin: 0;">Organization approved successfully.</p>
            </div>
        @endif

        @if (session('status') === 'organization-rejected')
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                <p style="margin: 0;">Organization rejected.</p>
            </div>
        @endif

        @if (session('status') === 'organization-deleted')
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #dc2626;">
                <p style="margin: 0;">Organization deleted.</p>
            </div>
        @endif

        <div class="card">
            <h3>Manage Organizations</h3>
            <p>Review submitted organizations and update their status.</p>

            <div class="filter-row">
                <a href="{{ route('admin.organizations.index') }}" class="{{ $statusFilter === '' ? 'active' : '' }}">All</a>
                <a href="{{ route('admin.organizations.index', ['status' => 'pending']) }}" class="{{ $statusFilter === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.organizations.index', ['status' => 'approved']) }}" class="{{ $statusFilter === 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('admin.organizations.index', ['status' => 'rejected']) }}" class="{{ $statusFilter === 'rejected' ? 'active' : '' }}">Rejected</a>
            </div>

            <div class="orgs-container">
                @forelse ($organizations as $organization)
                <div class="org-card">
                    <div style="display:flex;justify-content:space-between;gap:10px;align-items:start;">
                        <strong>{{ $organization->organization_name }}</strong>
                        <span class="status-badge status-{{ $organization->status ?? 'pending' }}">
                            {{ $organization->status ?? 'pending' }}
                        </span>
                    </div>
                    <p style="margin: 10px 0 6px;">{{ $organization->description ?: 'No description provided.' }}</p>
                    <small style="display:block; line-height:1.6;">
                        Owner: {{ $organization->user->name ?? 'N/A' }}<br>
                        Category: {{ $organization->category }}<br>
                        Type: {{ $organization->type }}<br>
                        Address: {{ $organization->address }}<br>
                        Contact: {{ $organization->contact_number }}<br>
                        Email: {{ $organization->email }}
                    </small>

                    <div class="actions">
                        @if (($organization->status ?? 'pending') !== 'approved')
                            <form method="POST" action="{{ route('admin.organizations.approve', $organization) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-approve">Approve</button>
                            </form>
                        @endif

                        @if (($organization->status ?? 'pending') !== 'rejected')
                            <form method="POST" action="{{ route('admin.organizations.reject', $organization) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-reject">Reject</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.organizations.delete', $organization) }}" onsubmit="return confirm('Delete this organization?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No organizations found for this filter.</p>
            @endforelse
            </div>
        </div>
    </div>
</div>

</body>
</html>