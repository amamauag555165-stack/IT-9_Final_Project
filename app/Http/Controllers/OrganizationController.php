<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(Request $request): View
    {
        $organizations = $request->user()
            ->organizations()
            ->latest()
            ->get();

        return view('volunteers.organization', [
            'organizations' => $organizations,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['status'] = 'pending';

        $request->user()->organizations()->create($validated);

        return redirect()
            ->route('organization.index')
            ->with('status', 'organization-submitted');
    }
}
