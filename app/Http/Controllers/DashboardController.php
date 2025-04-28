<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Certificate;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $upcomingEvents = Event::where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $myEvents = EventParticipant::with('event')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $myCertificates = Certificate::with('event')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $myAttendances = Attendance::with('event')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'upcomingEvents',
            'myEvents',
            'myCertificates',
            'myAttendances'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'prodi' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2099'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully.');
    }
} 