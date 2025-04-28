<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil statistik untuk cards
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $pendingUsers = User::where('status', 'pending')->count();
        $totalEvents = Event::count();
        $totalCertificates = Certificate::count();

        // Mengambil daftar user yang menunggu verifikasi
        $pendingVerifications = User::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Mengambil event terbaru
        $latestEvents = Event::latest()
            ->take(5)
            ->get();

        // Mengambil aktivitas terbaru
        $latestActivities = Activity::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'totalEvents',
            'totalCertificates',
            'pendingVerifications',
            'latestEvents',
            'latestActivities'
        ));
    }

    public function indexUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim' => 'required|string|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
            'user' => 'required|string|in:admin,member',
            'angkatan' => 'required|integer',
            'alasan_bergabung' => 'required|string',
        ]);

        if ($request->hasFile('ktm')) {
            $filePath = $request->file('ktm')->store('ktm', 'public');
            $validated['ktm'] = $filePath;
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nim' => 'required|string|max:255|unique:users,nim,' . $user->id,
            'prodi' => 'required|string|in:Sistem Informasi,Sistem Komputer,Bisnis Digital,Teknologi Informasi',
            'angkatan' => 'required|integer|min:2021|max:' . date('Y'),
            'phone' => 'required|string|max:255',
            'role' => 'required|string|in:user,anggota,pengurus,admin',
            'status' => 'required|string|in:pending,active,inactive',
        ]);

        try {
            $user->update($validated);
            return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function verifyUser(User $user)
    {
        try {
            \Log::info('Memulai proses verifikasi user', ['user_id' => $user->id]);
            
            $user->update([
                'email_verified_at' => now(),
                'status' => 'active',
                'role' => 'anggota'
            ]);
            
            \Log::info('User berhasil diverifikasi', ['user_id' => $user->id]);
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diverifikasi dan diaktifkan sebagai anggota.');
        } catch (\Exception $e) {
            \Log::error('Gagal memverifikasi user', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('admin.users.index')
                ->with('error', 'Gagal memverifikasi user: ' . $e->getMessage());
        }
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function resetUserPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil direset');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }
} 