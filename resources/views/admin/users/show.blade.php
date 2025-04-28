@extends('layouts.admin-tailwind')

@section('title', 'Detail User - Admin')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-2">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 flex flex-col items-center">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}" alt="Foto {{ $user->name }}" 
                                 class="w-48 h-48 rounded-full object-cover shadow-lg mb-4">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" 
                                 alt="Foto {{ $user->name }}" 
                                 class="w-48 h-48 rounded-full object-cover shadow-lg mb-4">
                        @endif
                        
                        <div class="flex gap-2">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : ($user->role == 'pengurus' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $user->status == 'active' ? 'bg-green-100 text-green-600' : ($user->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="w-full md:w-2/3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NIM</label>
                                <p class="mt-1 text-gray-900">{{ $user->nim }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Program Studi</label>
                                <p class="mt-1 text-gray-900">{{ $user->prodi }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Angkatan</label>
                                <p class="mt-1 text-gray-900">{{ $user->angkatan }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                                <p class="mt-1 text-gray-900">{{ $user->phone }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500">KTM</label>
                            <div class="mt-2">
                                @if($user->ktm)
                                    <img src="{{ Storage::url($user->ktm) }}" alt="KTM {{ $user->name }}" 
                                         class="max-w-xs rounded-lg shadow-sm hover:scale-105 transition-transform duration-300">
                                @else
                                    <p class="text-gray-500 italic">Belum upload KTM</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 