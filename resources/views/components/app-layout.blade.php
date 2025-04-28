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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen bg-light">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100">
            <div class="container mx-auto px-4 py-12">
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold">About Us</h3>
                        <p class="text-secondary/70">Athena E-Sport is your premier destination for competitive gaming and esports tournaments.</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="nav-link">Home</a></li>
                            <li><a href="#" class="nav-link">Tournaments</a></li>
                            <li><a href="#" class="nav-link">Games</a></li>
                            <li><a href="#" class="nav-link">Contact</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-secondary/70 hover:text-primary-500 transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-secondary/70 hover:text-primary-500 transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-secondary/70 hover:text-primary-500 transition-colors">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-secondary/70 hover:text-primary-500 transition-colors">
                                <i class="fab fa-discord text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold">Newsletter</h3>
                        <form class="space-y-2">
                            <input type="email" placeholder="Your email" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                            <button type="submit" class="btn-primary w-full">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-100 mt-12 pt-8 text-center text-secondary/70">
                    <p>&copy; {{ date('Y') }} Athena E-Sport. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html> 