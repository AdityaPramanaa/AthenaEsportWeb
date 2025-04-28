<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['required', 'numeric', 'digits_between:8,12', 'unique:users'],
            'prodi' => ['required', 'string', 'in:Sistem Informasi,Sistem Komputer,Bisnis Digital,Teknologi Informasi'],
            'angkatan' => ['required', 'numeric', 'min:2021', 'max:'.date('Y')],
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:users'],
            'ktm' => ['required', 'image', 'max:2048'],
            'alasan_bergabung' => ['required', 'string', 'min:50'],
        ]);

        $ktmPath = $request->file('ktm')->store('ktm', 'public');

        // Format nomor telepon
        $phone = '+62' . $request->phone;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'phone' => $phone,
            'ktm' => $ktmPath,
            'alasan_bergabung' => $request->alasan_bergabung,
            'role' => 'user'
        ]);

        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
} 