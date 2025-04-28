<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - UKM Athena E-Sport</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 flex flex-col">
            <div class="flex flex-col items-center py-6 border-b border-gray-800">
                <img src="{{ asset('images/athena.png') }}" alt="Logo" class="h-12 mb-2">
                <h5 class="text-lg font-bold">UKM Athena E-Sport</h5>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->is('admin/dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-speedometer2 mr-3"></i> Dashboard
                </a>
                <a href="/admin/users" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->is('admin/users*') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-people mr-3"></i> Kelola Anggota
                </a>
                <a href="/admin/events" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->is('admin/events*') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-calendar-event mr-3"></i> Kelola Event
                </a>
                <a href="/admin/news" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->is('admin/news*') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-newspaper mr-3"></i> Kelola Berita
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.galleries.*') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-images mr-3"></i> Kelola Galeri
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.messages.*') ? 'bg-blue-700' : '' }}">
                    <i class="bi bi-envelope mr-3"></i> Pesan Masuk
                    @php $unreadCount = \App\Models\Message::where('read_status', 'unread')->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-2 bg-red-500 text-xs rounded-full px-2 py-0.5">{{ $unreadCount }}</span>
                    @endif
                </a>
            </nav>
            <div class="mt-auto px-2 pb-4">
                <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-800">
                    <i class="bi bi-person mr-3"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 rounded-lg hover:bg-gray-800 text-red-400">
                        <i class="bi bi-box-arrow-right mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8">
            @yield('content')
        </main>
    </div>
</body>
</html> 