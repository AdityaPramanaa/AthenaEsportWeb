<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Athena E-Sport') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --primary: #2563eb; /* biru utama */
            --primary-light: #60a5fa;
            --primary-dark: #1e40af;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b; /* biru gelap */
            --text-secondary: #2563eb; /* biru utama */
        }
        body {
            background: var(--background);
            color: var(--text-main);
            font-family: 'Poppins', 'Inter', 'Lexend', Arial, Helvetica, sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', 'Lexend', 'Inter', Arial, Helvetica, sans-serif !important;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }
        .gradient-text {
            background: linear-gradient(90deg, #60a5fa 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition-all duration-200;
        }
        .btn-primary:active {
            @apply bg-blue-800;
        }
        .section-title {
            @apply text-3xl md:text-5xl font-bold mb-4 gradient-text;
            font-family: 'Poppins', 'Lexend', 'Inter', Arial, Helvetica, sans-serif !important;
        }
        .card {
            background: var(--card-bg);
            box-shadow: 0 2px 16px 0 rgba(59,130,246,0.08);
            border-radius: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            color: var(--text-main);
        }
        .card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 6px 24px 0 rgba(59,130,246,0.12);
        }
        .text-blue-500, .text-blue-600, .text-blue-700, .text-blue-900 {
            color: var(--primary) !important;
        }
        .bg-blue-100, .bg-blue-50, .bg-blue-200 {
            background-color: #eaf4ff !important;
        }
        .shadow-navbar {
            box-shadow: 0 2px 8px 0 rgba(30,41,59,0.06);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen bg-[var(--background)]">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="pt-6 pb-16 text-blue-900 min-h-[60vh]">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-12">
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">About Us</h3>
                        <p class="text-gray-700">Athena E-Sport adalah destinasi utama untuk gaming kompetitif dan turnamen esports.</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 transition">Home</a></li>
                            <li><a href="{{ route('games.index') }}" class="text-gray-700 hover:text-gray-900 transition">Games</a></li>
                            <li><a href="{{ route('events.index') }}" class="text-gray-700 hover:text-gray-900 transition">Events</a></li>
                            <li><a href="{{ route('news.index') }}" class="text-gray-700 hover:text-gray-900 transition">News</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-700 hover:text-gray-900 transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900 transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900 transition-colors">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-gray-900 transition-colors">
                                <i class="fab fa-discord text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">Newsletter</h3>
                        <form class="space-y-2">
                            <input type="email" 
                                   placeholder="Your email" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-gray-900 focus:ring-2 focus:ring-gray-200 transition-all">
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-gradient-to-r from-gray-700 to-gray-900 text-white rounded-lg hover:opacity-90 transition-all">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-200 mt-12 pt-8 text-center">
                    <p class="text-gray-700">&copy; {{ date('Y') }} Athena E-Sport. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Custom options
            Thumbs: false,
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["close"],
                },
            },
        });
    </script>
    @stack('scripts')
</body>
</html> 