@extends('layouts.admin-tailwind')

@section('title', 'Tambah User Baru')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah User Baru</h1>
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nama</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">NIM</label>
                <input type="text" name="nim" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nomor Telepon</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Role</label>
                <select name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900">
                    <option value="anggota">Anggota</option>
                    <option value="admin">Admin</option>
                    <option value="pengurus">Pengurus</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Upload KTM</label>
                <input type="file" name="ktm" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Angkatan</label>
                <input type="number" name="angkatan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Alasan Bergabung</label>
                <textarea name="alasan_bergabung" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 text-gray-900"></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-semibold">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection 