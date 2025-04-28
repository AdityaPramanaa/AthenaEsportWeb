@extends('layouts.app')
@section('title', 'Profil Saya - Athena E-Sport')
@section('content')
<div class="container py-12">
    <h1 class="section-title mb-8" style="font-family: 'Poppins', sans-serif;">Profil Saya</h1>
    <div class="max-w-2xl mx-auto card p-8">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : asset('images/default-profile.png') }}" alt="{{ Auth::user()->name }}" class="w-32 h-32 rounded-full border-4 border-blue-200 object-cover mb-4">
            <h2 class="text-2xl font-bold" style="color:#2563eb; font-family: 'Poppins', sans-serif;">{{ Auth::user()->name }}</h2>
            <p style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ Auth::user()->email }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Username</h3>
                <p style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ Auth::user()->username ?? '-' }}</p>
            </div>
            <div>
                <h3 class="font-semibold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">No. HP</h3>
                <p style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ Auth::user()->phone ?? '-' }}</p>
            </div>
            <div>
                <h3 class="font-semibold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Bergabung Sejak</h3>
                <p style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('profile.edit') }}" class="btn-primary px-8 py-3" style="font-family: 'Poppins', sans-serif;">Edit Profil</a>
        </div>
    </div>
</div>
@endsection 