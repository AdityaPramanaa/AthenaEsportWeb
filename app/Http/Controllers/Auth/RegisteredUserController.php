<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Memulai proses registrasi', ['data' => $request->except(['password', 'password_confirmation'])]);
            
            // Validasi input
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'nim' => ['required', 'numeric', 'digits_between:8,12', 'unique:users'],
                'prodi' => ['required', 'string', 'in:Sistem Informasi,Sistem Komputer,Bisnis Digital,Teknologi Informasi'],
                'angkatan' => ['required', 'numeric', 'min:2021', 'max:'.date('Y')],
                'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:users'],
                'ktm' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'alasan_bergabung' => ['required', 'string'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'nim.required' => 'NIM wajib diisi',
                'nim.numeric' => 'NIM harus berupa angka',
                'nim.digits_between' => 'NIM harus 8-12 digit',
                'nim.unique' => 'NIM sudah terdaftar',
                'prodi.required' => 'Program studi wajib dipilih',
                'prodi.in' => 'Program studi tidak valid',
                'angkatan.required' => 'Tahun angkatan wajib diisi',
                'angkatan.numeric' => 'Tahun angkatan harus berupa angka',
                'angkatan.min' => 'Tahun angkatan minimal 2021',
                'angkatan.max' => 'Tahun angkatan maksimal '.date('Y'),
                'phone.required' => 'Nomor WhatsApp wajib diisi',
                'phone.numeric' => 'Nomor WhatsApp harus berupa angka',
                'phone.digits_between' => 'Nomor WhatsApp harus 10-12 digit',
                'phone.unique' => 'Nomor WhatsApp sudah terdaftar',
                'ktm.required' => 'Foto KTM wajib diunggah',
                'ktm.image' => 'File harus berupa gambar',
                'ktm.mimes' => 'Format gambar harus jpeg/jpg/png',
                'ktm.max' => 'Ukuran gambar maksimal 2MB',
                'alasan_bergabung.required' => 'Alasan bergabung wajib diisi'
            ]);

            \Log::info('Validasi berhasil, memproses upload KTM');

            // Upload KTM
            $ktmPath = null;
            if ($request->hasFile('ktm')) {
                $ktmPath = $request->file('ktm')->store('ktm', 'public');
                \Log::info('KTM berhasil diupload', ['path' => $ktmPath]);
            }

            // Format nomor telepon
            $phone = '+62' . ltrim($request->phone, '0');

            \Log::info('Membuat user baru');
            
            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nim' => $validated['nim'],
                'prodi' => $validated['prodi'],
                'angkatan' => $validated['angkatan'],
                'phone' => $phone,
                'ktm' => $ktmPath,
                'alasan_bergabung' => $validated['alasan_bergabung'],
                'role' => 'user',
                'status' => 'pending',
            ]);

            \Log::info('User berhasil dibuat', ['user_id' => $user->id]);

            // Nonaktifkan sementara event email verifikasi
            // event(new Registered($user));

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Pendaftaran berhasil! Silakan lengkapi profil Anda dan tunggu verifikasi dari admin.');
        } catch (\Exception $e) {
            \Log::error('Error saat registrasi: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Hapus file KTM jika ada error setelah upload
            if (isset($ktmPath)) {
                Storage::delete('public/' . $ktmPath);
            }
            
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'ktm']))
                ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage()]);
        }
    }
} 