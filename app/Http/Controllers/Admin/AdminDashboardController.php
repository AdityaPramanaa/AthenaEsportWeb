<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Event;
use App\Models\News;
use App\Models\Certificate;
use App\Models\Activity;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Data untuk cards
        $totalUsers = User::count();
        $pendingUsers = User::whereNull('email_verified_at')->count();
        $totalEvents = Event::count();
        $activeEvents = Event::where('status', 'published')->count();
        $totalNews = News::count();
        $publishedNews = News::where('status', 'published')->count();
        $totalMessages = Message::count();
        $unreadMessages = Message::where('read_status', 'unread')->count();
        $totalCertificates = Certificate::count();

        // Data untuk pending verifications
        $pendingVerifications = User::whereNull('email_verified_at')
            ->select('id', 'name', 'nim', 'prodi')
            ->latest()
            ->get();

        // Data untuk latest events
        $latestEvents = Event::select('id', 'title', 'event_date', 'status')
            ->latest()
            ->take(5)
            ->get();

        // Data untuk latest activities
        $latestActivities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Data untuk charts (jika diperlukan)
        $monthlyUsers = User::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $monthlyEvents = Event::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'totalEvents',
            'activeEvents',
            'totalNews',
            'publishedNews',
            'totalMessages',
            'unreadMessages',
            'monthlyUsers',
            'monthlyEvents',
            'totalCertificates',
            'pendingVerifications',
            'latestEvents',
            'latestActivities'
        ));
    }
}
