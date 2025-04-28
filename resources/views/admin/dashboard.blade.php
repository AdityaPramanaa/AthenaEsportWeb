@extends('layouts.admin-tailwind')

@section('title', 'Dashboard')

@section('content')
<div class="px-2 md:px-6 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Dashboard Admin</h1>
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div>
                <div class="text-sm text-gray-900">Total Anggota</div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                <i class="fas fa-user-clock fa-lg"></i>
            </div>
            <div>
                <div class="text-sm text-gray-900">Menunggu Verifikasi</div>
                <div class="text-2xl font-bold text-gray-900">{{ $pendingUsers }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <i class="fas fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <div class="text-sm text-gray-900">Total Event</div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
            <div class="bg-cyan-100 text-cyan-600 rounded-full p-3">
                <i class="fas fa-certificate fa-lg"></i>
            </div>
            <div>
                <div class="text-sm text-gray-900">Total Sertifikat</div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalCertificates }}</div>
            </div>
        </div>
    </div>
    <!-- Pending Verifikasi & Event Terbaru -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-yellow-700">Menunggu Verifikasi</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Lihat Semua</a>
            </div>
            @if($pendingVerifications->isEmpty())
                <p class="text-center text-gray-400">Tidak ada user yang menunggu verifikasi</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($pendingVerifications as $user)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">NIM: {{ $user->nim }} | Prodi: {{ $user->prodi }}</div>
                        </div>
                        <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">Verifikasi</button>
                        </form>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-green-700">Event Terbaru</h2>
                <a href="{{ route('admin.events.index') }}" class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">Lihat Semua</a>
            </div>
            @if($latestEvents->isEmpty())
                <p class="text-center text-gray-400">Belum ada event yang dibuat</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($latestEvents as $event)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $event->title }}</div>
                            <div class="text-xs text-gray-500">
                                @if($event->event_date)
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                @else
                                    Tanggal belum ditentukan
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-2 py-0.5 rounded text-xs {{ $event->type == 'tournament' ? 'bg-red-100 text-red-600' : ($event->type == 'gathering' ? 'bg-green-100 text-green-600' : 'bg-cyan-100 text-cyan-600') }}">{{ ucfirst($event->type) }}</span>
                            <span class="px-2 py-0.5 rounded text-xs {{ $event->status == 'published' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }}">{{ ucfirst($event->status) }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-blue-700 mb-4">Aktivitas Terbaru</h2>
        @if($latestActivities->isEmpty())
            <p class="text-center text-gray-400">Belum ada aktivitas</p>
        @else
            <ul class="space-y-4">
                @foreach($latestActivities as $activity)
                <li class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $activity->type == 'event' ? 'bg-green-100 text-green-600' : ($activity->type == 'user' ? 'bg-blue-100 text-blue-600' : 'bg-cyan-100 text-cyan-600') }}">
                        <i class="fas fa-{{ $activity->type == 'event' ? 'calendar' : ($activity->type == 'user' ? 'user' : 'certificate') }}"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ $activity->description }}</div>
                        <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection 