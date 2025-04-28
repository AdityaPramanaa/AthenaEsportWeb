@extends('layouts.admin-tailwind')

@section('title', 'Tambah Galeri')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Galeri</h1>
            <a href="{{ route('admin.galleries.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" id="createGalleryForm" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Foto <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-black">
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-black">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-black">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Foto <span class="text-red-500">*</span></label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <span class="text-xs text-gray-400">Format: JPG, JPEG, PNG (Max. 2MB)</span>
                        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <div id="imagePreview" class="mt-2 hidden">
                            <label class="block text-xs text-gray-500 mb-1">Preview Foto:</label>
                            <img src="#" alt="Preview" class="max-h-48 rounded shadow">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex flex-col md:flex-row justify-end gap-2">
                    <button type="reset" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Reset</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center gap-2" id="submitBtn">
                        <svg class="animate-spin h-4 w-4 mr-2 hidden" id="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview gambar yang dipilih
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.querySelector('#imagePreview img').src = ev.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
    // Handle form submission
    document.getElementById('createGalleryForm')?.addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('spinner').classList.remove('hidden');
    });
</script>
@endpush 