<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['organization', 'volunteers', 'announcements'])
            ->where('approval_status', 'approved');

        // Filter by organization
        if ($request->filled('organization')) {
            $query->where('organization_id', $request->organization);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by date (schedule)
        if ($request->filled('date')) {
            $query->whereDate('event_date', $request->date);
        }

        $events = $query->latest()->paginate(9);
        $organizations = \App\Models\Organization::where('status', 'approved')->get();
        return view('events.event', compact('events', 'organizations'));
    }

    public function create()
    {
        $user = auth()->user();
        $organization = $user->organizations()->where('status', 'approved')->first();

        if (!$organization) {
            return redirect()->route('organization.index')
                ->with('error', 'You need to create and have an approved organization before creating events.');
        }

        return view('events.eventcreate', compact('organization'));
    }

    public function show(Event $event)
    {
        $event->load(['organization', 'volunteers', 'announcements', 'creator']);
        return view('events.show', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'required_volunteers' => 'required|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $organization = auth()->user()->organizations()->where('status', 'approved')->first();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
        }

        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'required_volunteers' => $validated['required_volunteers'],
            'status' => $validated['status'],
            'approval_status' => 'pending',
            'created_by' => auth()->id(),
            'organization_id' => $organization->id,
            'image' => $imagePath,
        ]);

        return redirect()->route('events')->with('success', 'Event created successfully!');
    }

    public function join(Event $event)
    {
        $user = auth()->user();

        if ($event->volunteers()->where('user_id', $user->id)->exists()) {
            return redirect()->route('events')->with('error', 'You have already joined this event.');
        }

        if ($event->volunteers()->count() >= $event->required_volunteers) {
            return redirect()->route('events')->with('error', 'This event has reached the required number of volunteers.');
        }

        $event->volunteers()->attach($user->id);

        return redirect()->route('events')->with('success', 'You have successfully joined the event!');
    }

    public function leave(Event $event)
    {
        $user = auth()->user();

        if (!$event->volunteers()->where('user_id', $user->id)->exists()) {
            return redirect()->route('userdashboard')->with('error', 'You have not joined this event.');
        }

        $event->volunteers()->detach($user->id);

        return redirect()->route('userdashboard')->with('success', 'You have successfully left the event.');
    }

    public function edit(Event $event)
    {
        if ($event->created_by !== auth()->id()) {
            return redirect()->route('events')->with('error', 'You can only edit your own events.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->created_by !== auth()->id()) {
            return redirect()->route('events')->with('error', 'You can only edit your own events.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'required_volunteers' => 'required|integer|min:1',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('events')->with('success', 'Event updated successfully!');
    }

    public function createAnnouncement(Request $request, Event $event)
    {
        if ($event->created_by !== auth()->id()) {
            return redirect()->route('events')->with('error', 'You can only create announcements for your own events.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Announcement::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return redirect()->route('events')->with('success', 'Announcement created successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->created_by !== auth()->id()) {
            return redirect()->route('events')->with('error', 'You can only cancel your own events.');
        }

        $event->delete();

        return redirect()->route('events')->with('success', 'Event cancelled successfully.');
    }

    public function approve(Event $event)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Only admins can approve events.');
        }

        $event->update(['approval_status' => 'approved']);

        return redirect()->back()->with('success', 'Event approved successfully.');
    }

    public function reject(Event $event)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Only admins can reject events.');
        }

        $event->update(['approval_status' => 'rejected']);

        return redirect()->back()->with('success', 'Event rejected successfully.');
    }
}
