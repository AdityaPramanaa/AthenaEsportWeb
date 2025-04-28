@extends('layouts.app')
@section('title', 'Games - Athena E-Sport')
@section('content')
<div class="container py-12">
    <h1 class="section-title mb-8" style="font-family: 'Poppins', sans-serif;">Games</h1>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($games as $game)
        <div class="card p-6 flex flex-col items-center fade-in-up hover:scale-105">
            <img src="{{ asset($game->image_path) }}" alt="{{ $game->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">{{ $game->name }}</h2>
            <p class="mb-4 text-center" style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ $game->description }}</p>
            <a href="{{ route('games.show', $game) }}" class="btn-primary w-full" style="font-family: 'Poppins', sans-serif;">Lihat Detail</a>
        </div>
        @empty
        <div class="col-span-full text-center text-blue-400 py-8" style="font-family: 'Poppins', sans-serif;">Tidak ada game yang tersedia.</div>
        @endforelse
    </div>
</div>
@endsection 