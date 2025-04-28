@extends('layouts.app')

@section('title', 'Tentang Kami - UKM Athena E-Sport')

@section('content')
<div class="container py-12">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="section-title mb-6" style="font-family: 'Poppins', sans-serif;">Tentang Kami</h1>
            <p class="text-lg mb-6" style="color:#1e293b; font-family: 'Poppins', sans-serif;">Didirikan pada hari Jumat, 3 Mei 2024, UKM Athena E-Sport menjadi wadah bagi mahasiswa yang memiliki passion di dunia e-sport untuk mengembangkan potensi mereka.</p>
            <div class="flex gap-4 mb-8">
                <a href="{{ route('events.index') }}" class="btn-primary" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-calendar-alt mr-2"></i>Lihat Event
                </a>
                <a href="#contact" class="btn-primary" style="font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
        <div class="flex justify-center">
            <img src="{{ asset('images/game.jpg') }}" alt="UKM Athena E-Sport" class="rounded-2xl shadow-xl w-full max-w-md">
        </div>
    </div>
    <div class="mt-16">
        <h2 class="section-title text-center mb-8" style="font-family: 'Poppins', sans-serif;">Visi & Misi</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="card p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-3">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Visi</h3>
                </div>
                <p style="color:#1e293b; font-family: 'Poppins', sans-serif;">Menjadi UKM terdepan dalam pengembangan bakat dan prestasi di bidang e-sport, serta menjadi wadah yang inspiratif bagi para gamers untuk berkembang secara profesional.</p>
            </div>
            <div class="card p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-3">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-bold" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Misi</h3>
                </div>
                <ul class="list-disc pl-6 space-y-2" style="color:#1e293b; font-family: 'Poppins', sans-serif;">
                    <li>Mengembangkan bakat dan potensi mahasiswa dalam bidang e-sport</li>
                    <li>Menyelenggarakan turnamen dan kompetisi e-sport berkualitas</li>
                    <li>Membangun komunitas gamers yang solid dan profesional</li>
                    <li>Meningkatkan prestasi dalam kompetisi e-sport tingkat nasional</li>
                </ul>
            </div>
        </div>
    </div>
    
@endsection 