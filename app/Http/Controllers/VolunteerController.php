<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\VolunteerHour;
use Carbon\Carbon;

class VolunteerController extends Controller
{
    public function userdashboard()
    {
        $user = auth()->user();
        $joinedEvents = $user->events()->with('organization')->where('status', '!=', 'completed')->latest()->get();
        $completedEvents = $user->events()->with('organization')->where('status', 'completed')->latest()->get();

        // Calculate and store hours for completed events
        foreach ($completedEvents as $event) {
            $existingHours = VolunteerHour::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first();

            if (!$existingHours) {
                // Calculate hours from start_time to end_time
                $startTime = Carbon::parse($event->start_time);
                $endTime = Carbon::parse($event->end_time);
                $hoursWorked = $startTime->diffInHours($endTime);

                VolunteerHour::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'hours_worked' => $hoursWorked,
                    'work_date' => $event->event_date,
                ]);
            }
        }

        $totalHours = $user->total_hours;

        return view('volunteers.userdashboard', compact('joinedEvents', 'completedEvents', 'totalHours'));
    }

    public function myevents()
    {
        $user = auth()->user();
        $myEvents = Event::with(['organization', 'volunteers', 'announcements'])
            ->where('created_by', $user->id)
            ->latest()
            ->get();

        return view('volunteers.myevents', compact('myEvents'));
    }

    public function accountSettings()
    {
        return view('volunteers.accountsetting');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('account.settings')
                ->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.settings')
            ->with('success', 'Password changed successfully.');
    }
}
