<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'eventCount' => Event::count(),
            'volunteerCount' => Volunteer::count(),
            'pendingEventCount' => Event::where('approval_status', 'pending')->count(),
            'pendingOrganizations' => Organization::where('status', 'pending')->latest()->get(),
            'pendingEvents' => Event::with(['organization', 'creator'])->where('approval_status', 'pending')->latest()->get(),
            'activeEvents' => Event::with(['organization', 'creator'])
                ->where('approval_status', 'approved')
                ->whereIn('status', ['upcoming', 'ongoing'])
                ->latest()
                ->get(),
        ]);
    }

    public function organizations(Request $request): View
    {
        $statusFilter = $request->string('status')->toString();
        $query = Organization::with('user')->latest();

        if (in_array($statusFilter, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $statusFilter);
        }

        return view('admin.organization', [
            'organizations' => $query->get(),
            'statusFilter' => $statusFilter,
        ]);
    }

    public function events(Request $request): View
    {
        $statusFilter = $request->string('status')->toString();
        $query = Event::with(['organization', 'creator'])->latest();

        if (in_array($statusFilter, ['pending', 'approved', 'rejected'], true)) {
            $query->where('approval_status', $statusFilter);
        }

        return view('admin.manageevent', [
            'events' => $query->get(),
            'statusFilter' => $statusFilter,
        ]);
    }

    public function approveOrganization(Organization $organization): RedirectResponse
    {
        $organization->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'organization-approved');
    }

    public function rejectOrganization(Organization $organization): RedirectResponse
    {
        $organization->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.organizations.index')
            ->with('status', 'organization-rejected');
    }

    public function deleteOrganization(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return redirect()
            ->route('admin.organizations.index')
            ->with('status', 'organization-deleted');
    }
}
