@extends('layouts.admin-tailwind')

@section('title', 'Kelola Galeri')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Galeri</h1>
        <a href="{{ route('admin.galleries.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Tambah Galeri</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow p-6">
        @if($galleries->isEmpty())
            <p class="text-center text-gray-400">Belum ada galeri yang ditambahkan</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galleries as $gallery)
                <div class="bg-gray-50 rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-full h-48 object-cover" alt="{{ $gallery->title }}">
                    <div class="p-4 flex-1 flex flex-col">
                        <h5 class="font-semibold text-lg mb-1 text-black">{{ $gallery->title }}</h5>
                        @if($gallery->event)
                            <p class="text-xs text-black mb-1">Event: {{ $gallery->event->title }}</p>
                        @endif
                        <p class="text-sm text-black flex-1">{{ Str::limit($gallery->description, 100) }}</p>
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 flex items-center gap-1"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 flex items-center gap-1"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pt-6">{{ $galleries->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('css')
<style>
    .gallery-card {
        transition: transform 0.2s ease-in-out;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
    }
    
    .gallery-img-container {
        position: relative;
        overflow: hidden;
        padding-top: 75%; /* 4:3 Aspect Ratio */
    }
    
    .gallery-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-card:hover .gallery-img {
        transform: scale(1.1);
    }
    
    .btn-group {
        gap: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .d-sm-flex {
            flex-direction: column;
            gap: 1rem;
        }
        
        .col-md-6 {
            padding: 0.5rem;
        }
        
        .gallery-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Handle delete confirmation
    $('.delete-gallery').click(function() {
        const galleryId = $(this).data('id');
        const galleryTitle = $(this).data('title');
        $('#galleryTitle').text(galleryTitle);
        $('#deleteForm').attr('action', `/admin/galleries/${galleryId}`);
        $('#deleteModal').modal('show');
    });
});
</script>
@endpush 