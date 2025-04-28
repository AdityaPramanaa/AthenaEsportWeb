<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Event;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        try {
            \Log::info('Memulai pengambilan data untuk halaman home');

            // Ambil berita terbaru
            $news = News::where('status', 'published')
                ->latest()
                ->take(6)
                ->get();
                
            // Ambil galleries terbaru untuk ditampilkan
            $galleries = Gallery::where('status', 'published')
                ->latest()
                ->take(5)
                ->get();

            // Ambil event terbaru yang published
            $latestEvents = Event::where('status', 'published')
                ->where(function($query) {
                    $query->where('event_date', '>=', now())
                          ->orWhereNull('event_date');
                })
                ->orderBy('event_date', 'asc')
                ->take(3)
                ->get();

            \Log::info('Data event berhasil diambil', [
                'total_events' => Event::count(),
                'published_events' => Event::where('status', 'published')->count(),
                'future_events' => Event::where('event_date', '>=', now())->count(),
                'latest_events_count' => $latestEvents->count()
            ]);

            // Ambil pesan untuk user yang login
            $messages = Message::with('replies')
                ->orderBy('created_at', 'desc')
                ->get();

            // Hitung total anggota (tidak termasuk admin)
            $totalMembers = User::where('email_verified_at', '!=', null)
                ->where('role', '!=', 'admin')
                ->count();
            
            // Hitung total events (tanpa filter status)
            $totalEvents = Event::count();
            
            // Hitung total news yang dipublish dari database
            $totalNews = News::where('status', 'published')->count();

            return view('home', compact(
                'news', 
                'galleries',
                'latestEvents',
                'messages',
                'totalMembers',
                'totalEvents',
                'totalNews'
            ));
        } catch (\Exception $e) {
            \Log::error('Error pada halaman home: ' . $e->getMessage());
            
            // Set nilai default untuk variabel yang diperlukan
            return view('home', [
                'news' => collect([]),
                'galleries' => collect([]),
                'latestEvents' => collect([]),
                'messages' => collect([]),
                'totalMembers' => 0,
                'totalEvents' => 0,
                'totalNews' => 0,
                'error' => 'Terjadi kesalahan saat memuat data'
            ]);
        }
    }

    public function about()
    {
        return view('about');
    }
} 