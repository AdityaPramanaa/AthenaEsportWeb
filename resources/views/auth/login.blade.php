<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-white">
        <div class="w-full max-w-md px-6 py-8">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Masuk ke Akun Anda
                </h2>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-blue-600 bg-blue-50 p-4 rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email/NIM -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email atau NIM
                    </label>
                    <input id="email" name="email" type="text" required 
                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email atau NIM anda">
                    @error('email')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-700 transition-colors duration-200" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password" required
                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200"
                        placeholder="Masukkan password anda">
                    @error('password')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="rounded border-gray-300 bg-gray-50 text-blue-600 shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                            Daftar
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Animasi loading saat submit
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;

        form.addEventListener('submit', () => {
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            `;
        });
    </script>
    @endpush
</x-app-layout> 