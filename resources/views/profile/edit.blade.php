@extends('layouts.app')
@section('title', 'Edit Profil - Athena E-Sport')
@section('content')
<div class="container py-12">
    <h1 class="section-title mb-8" style="font-family: 'Poppins', sans-serif;">Edit Profil</h1>
    <div class="max-w-2xl mx-auto">
        <!-- Profile Information and Password -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Profile Photo -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-blue-600">Foto Profil</h2>
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative group mb-4">
                            <img id="preview-image" src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : asset('images/default-profile.png') }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-blue-200 object-cover transition-all duration-300 group-hover:opacity-75">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <label for="profile_photo" class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-camera mr-2"></i>Ubah Foto
                                </label>
                            </div>
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <p class="text-sm text-gray-500 text-center">Klik foto untuk mengubah (Maks. 2MB)</p>
                        @error('profile_photo')
                            <p class="text-sm text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Profile Information -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-blue-600">Informasi Profil</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Nama</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('name')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('phone')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-blue-600">Ubah Password</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Password Saat Ini</label>
                            <input type="password" name="current_password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('current_password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Password Baru</label>
                            <input type="password" name="password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold mb-1 text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>

                        <div class="text-sm text-gray-500">
                            <p>Lupa password? 
                                <a href="#" onclick="showContactAdmin()" class="text-blue-600 hover:text-blue-700">Hubungi Admin</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center pt-6">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Contact Admin Modal -->
<div id="contact-admin-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold mb-4">Hubungi Admin</h3>
        <form id="contact-admin-form" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1 text-gray-700">Pesan untuk Admin</label>
                <textarea id="admin-content" name="content" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    placeholder="Jelaskan masalah Anda..."></textarea>
                <p id="message-error" class="text-sm text-red-500 mt-1 hidden"></p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideContactAdmin()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview-image');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function showContactAdmin() {
    event.preventDefault();
    document.getElementById('contact-admin-modal').classList.remove('hidden');
    document.getElementById('contact-admin-modal').classList.add('flex');
}

function hideContactAdmin() {
    document.getElementById('contact-admin-modal').classList.add('hidden');
    document.getElementById('contact-admin-modal').classList.remove('flex');
}

document.getElementById('contact-admin-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const messageError = document.getElementById('message-error');
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Reset error message
    messageError.classList.add('hidden');
    
    // Show loading state with SweetAlert2
    Swal.fire({
        title: 'Mengirim Pesan',
        text: 'Mohon tunggu sebentar...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('{{ route("admin.messages.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            pesan: document.getElementById('admin-content').value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Terjadi kesalahan saat mengirim pesan');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Show success message with SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: true,
                confirmButtonText: 'Oke',
                confirmButtonColor: '#2563eb'
            });
            form.reset();
            hideContactAdmin();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan saat mengirim pesan');
        }
    })
    .catch(error => {
        // Show error message with SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.message,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#dc2626'
        });
    });
});
</script>
@endpush 