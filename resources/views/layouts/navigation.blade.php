<!-- Navigation -->
<nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-lg">
    <div class="container mx-auto px-2 sm:px-4">
        <div class="flex items-center justify-between h-14 sm:h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Athena E-Sport" class="h-7 sm:h-8 w-auto brightness-0" style="filter: invert(0);">
                    <span class="ml-2 sm:ml-3 text-lg sm:text-xl font-orbitron font-bold text-gray-900 hidden sm:block" style="font-family: 'Poppins', sans-serif; letter-spacing: 1px;">Athena <span class="text-gray-900">E-Sport</span></span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-6 lg:space-x-8">
                @auth
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i>Dashboard
                    </a>
                    @endif
                @endauth
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('games.index') }}" class="nav-link {{ request()->routeIs('games.*') ? 'active' : '' }}">
                    <i class="fas fa-gamepad mr-2"></i>Games
                </a>
                <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar mr-2"></i>Events
                </a>
                <a href="{{ route('news.index') }}" class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper mr-2"></i>News
                </a>
            </div>

            <!-- User Menu & Mobile Button -->
            <div class="flex items-center gap-2 sm:gap-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 text-gray-900 hover:text-gray-700 transition-colors">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full border-2 border-gray-200 object-cover">
                            @else
                                <div class="h-8 w-8 rounded-full border-2 border-gray-200 bg-gray-100 flex items-center justify-center text-gray-900">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <span class="hidden sm:block text-gray-900">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 py-2 bg-white/95 border border-gray-200 rounded-lg shadow-xl backdrop-blur-xl" style="display: none;">
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-tachometer-alt w-5 mr-2"></i> Dashboard Admin
                            </a>
                            <div class="border-b border-gray-200 my-1"></div>
                            @endif
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user w-5 mr-2"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 sm:px-6 py-1.5 sm:py-2 text-sm sm:text-base rounded-xl font-bold text-white bg-gradient-to-r from-gray-700 to-gray-900 shadow-md hover:scale-105 hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                        <span class="hidden xs:inline">Login</span>
                        <i class="fas fa-sign-in-alt xs:hidden"></i>
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-900 hover:text-gray-700 p-2">
                    <i x-show="!mobileMenuOpen" class="fas fa-bars text-lg sm:text-xl"></i>
                    <i x-show="mobileMenuOpen" class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-200 shadow-xl" style="display: none;">
        <div class="container mx-auto px-4 py-3 space-y-1">
            @auth
                @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-5 sm:w-6"></i> Dashboard
                </a>
                @endif
            @endauth
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home w-5 sm:w-6"></i> Home
            </a>
            <a href="{{ route('games.index') }}" class="mobile-nav-link {{ request()->routeIs('games.*') ? 'active' : '' }}">
                <i class="fas fa-gamepad w-5 sm:w-6"></i> Games
            </a>
            <a href="{{ route('events.index') }}" class="mobile-nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar w-5 sm:w-6"></i> Events
            </a>
            <a href="{{ route('news.index') }}" class="mobile-nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper w-5 sm:w-6"></i> News
            </a>
            @guest
                <div class="pt-3 mt-3 border-t border-gray-200">
                    <a href="{{ route('register') }}" class="w-full flex justify-center items-center gap-2 px-4 sm:px-6 py-2 rounded-xl font-bold text-white bg-gradient-to-r from-gray-700 to-gray-900 shadow-md hover:scale-105 hover:shadow-xl transition-all duration-200 mb-2 text-sm sm:text-base">
                        <span>Register</span>
                        <i class="fas fa-user-plus"></i>
                    </a>
                    <a href="{{ route('login') }}" class="w-full flex justify-center items-center gap-2 px-4 sm:px-6 py-2 rounded-xl font-bold text-white bg-gradient-to-r from-gray-700 to-gray-900 shadow-md hover:scale-105 hover:shadow-xl transition-all duration-200 text-sm sm:text-base">
                        <span>Login</span>
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-14 sm:h-16"></div>

<style>
    .nav-link {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: #111827;
        padding: 0.375rem 1rem;
        border-radius: 0.75rem;
        transition: all 0.2s cubic-bezier(.4,2,.3,1);
        position: relative;
        display: flex;
        align-items: center;
        background: transparent;
        overflow: hidden;
        font-size: 0.9375rem;
    }
    .nav-link:after {
        content: '';
        position: absolute;
        left: 20%;
        right: 20%;
        bottom: 0.25rem;
        height: 2px;
        background: linear-gradient(90deg,#111827,#374151);
        border-radius: 2px;
        transform: scaleX(0);
        transition: transform 0.3s cubic-bezier(.4,2,.3,1);
    }
    .nav-link:hover:after, .nav-link.active:after {
        transform: scaleX(1);
    }
    .nav-link:hover, .nav-link.active {
        color: #374151;
        background: rgba(17,24,39,0.05);
        font-weight: 700;
        box-shadow: 0 2px 12px #11182711;
    }
    .mobile-nav-link {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: #111827;
        border-radius: 0.75rem;
        padding: 0.625rem 1rem;
        transition: all 0.2s cubic-bezier(.4,2,.3,1);
        display: flex;
        align-items: center;
        background: transparent;
        position: relative;
        overflow: hidden;
        font-size: 0.9375rem;
    }
    .mobile-nav-link:after {
        content: '';
        position: absolute;
        left: 20%;
        right: 20%;
        bottom: 0.25rem;
        height: 2px;
        background: linear-gradient(90deg,#111827,#374151);
        border-radius: 2px;
        transform: scaleX(0);
        transition: transform 0.3s cubic-bezier(.4,2,.3,1);
    }
    .mobile-nav-link:hover:after, .mobile-nav-link.active:after {
        transform: scaleX(1);
    }
    .mobile-nav-link:hover, .mobile-nav-link.active {
        color: #374151;
        background: rgba(17,24,39,0.05);
        font-weight: 700;
        box-shadow: 0 2px 12px #11182711;
    }

    /* Tambahan untuk breakpoint extra small */
    @media (max-width: 475px) {
        .xs\:hidden {
            display: none;
        }
        .xs\:inline {
            display: inline;
        }
    }
</style>

@push('scripts')
<script>
    // Navbar Scroll Effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('nav');
        if (window.scrollY > 0) {
            navbar.classList.add('border-cyan-200');
            navbar.classList.add('bg-white');
        } else {
            navbar.classList.remove('border-cyan-200');
            navbar.classList.remove('bg-white');
        }
    });
</script>
@endpush 