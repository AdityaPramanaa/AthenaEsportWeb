<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-blue-100 to-blue-300 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-2" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Daftar Anggota Baru</h2>
                <p class="mt-2 text-base" style="color:#1e293b; font-family: 'Poppins', sans-serif;">Bergabunglah dengan komunitas gaming terbesar di kampus</p>
            </div>
            <!-- Form Card -->
            <div class="bg-white/90 rounded-2xl shadow-xl p-6 md:p-8 border border-blue-100">
                @if($errors->any())
                    <div class="bg-red-100 border border-red-300 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-500">Terjadi kesalahan:</h3>
                                <div class="mt-2 text-sm text-red-400">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="Masukkan nama lengkap" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="contoh@email.com" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <!-- NIM -->
                    <div>
                        <label for="nim" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required pattern="[0-9]+" title="NIM harus berupa angka" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="Masukkan NIM" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <!-- Program Studi -->
                    <div>
                        <label for="prodi" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Program Studi</label>
                        <select name="prodi" id="prodi" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" style="font-family: 'Poppins', sans-serif;">
                            <option value="" disabled selected>Pilih Program Studi</option>
                            <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Sistem Komputer" {{ old('prodi') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
                            <option value="Bisnis Digital" {{ old('prodi') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                            <option value="Teknologi Informasi" {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                        </select>
                    </div>
                    <!-- Angkatan -->
                    <div>
                        <label for="angkatan" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Angkatan</label>
                        <select name="angkatan" id="angkatan" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" style="font-family: 'Poppins', sans-serif;">
                            <option value="" disabled selected>Pilih Angkatan</option>
                            @for($i = date('Y'); $i >= 2021; $i--)
                                <option value="{{ $i }}" {{ old('angkatan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- No. WhatsApp -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">No. WhatsApp</label>
                        <div class="flex rounded-lg shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-blue-200 bg-blue-50 text-blue-600 text-sm">+62</span>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required pattern="[0-9]+" title="Nomor WhatsApp harus berupa angka" class="form-input block w-full bg-white border-blue-200 rounded-none rounded-r-lg focus:ring-blue-500 focus:border-blue-500 text-[#1e293b]" placeholder="8xxxxxxxxxx" style="font-family: 'Poppins', sans-serif;">
                        </div>
                    </div>
                    <!-- Foto KTM -->
                    <div>
                        <label for="ktm" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Foto KTM</label>
                        <input type="file" name="ktm" id="ktm" required accept="image/*" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" style="font-family: 'Poppins', sans-serif;">
                        <p class="mt-2 text-sm text-blue-400" style="font-family: 'Poppins', sans-serif;">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                    </div>
                    <!-- Alasan Bergabung -->
                    <div>
                        <label for="alasan_bergabung" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Alasan Bergabung</label>
                        <textarea name="alasan_bergabung" id="alasan_bergabung" rows="4" required class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="Ceritakan alasanmu ingin bergabung dengan UKM Athena E-Sport" style="font-family: 'Poppins', sans-serif;">{{ old('alasan_bergabung') }}</textarea>
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Password</label>
                        <input type="password" name="password" id="password" required minlength="8" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="Minimal 8 karakter" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold mb-1" style="font-family: 'Poppins', sans-serif; color:#2563eb;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 bg-white text-[#1e293b]" placeholder="Masukkan ulang password" style="font-family: 'Poppins', sans-serif;">
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-colors duration-200" style="font-family: 'Poppins', sans-serif;">
                            <span class="inline-flex items-center">Daftar <i class="fas fa-arrow-right ml-2"></i></span>
                        </button>
                    </div>
                </form>
                <div class="mt-6 text-center">
                    <p class="text-sm" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:underline transition-colors duration-200" style="font-family: 'Poppins', sans-serif;">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nimInput = document.getElementById('nim');
        const phoneInput = document.getElementById('phone');
        nimInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    </script>
    @endpush
</x-app-layout> 