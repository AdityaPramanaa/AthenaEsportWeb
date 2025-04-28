@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="image-container" data-title="{{ $news->title }}">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="news-image w-full h-96 object-cover hover:opacity-75 transition-opacity cursor-pointer">
            </div>
            
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $news->title }}</h1>
                
                <div class="flex items-center text-gray-600 mb-6">
                    <span class="mr-4">
                        <i class="fas fa-user mr-2"></i>
                        {{ $news->user->name }}
                    </span>
                    <span>
                        <i class="fas fa-calendar mr-2"></i>
                        {{ $news->created_at->format('d M Y') }}
                    </span>
                </div>

                <div class="prose max-w-none">
                    {!! $news->content !!}
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('news.index') }}" class="inline-block bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css" rel="stylesheet">
<style>
    .image-container {
        position: relative;
        cursor: zoom-in;
    }
    .viewer-title {
        color: white;
        font-size: 16px;
        padding: 8px 16px;
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.image-container');
    const viewer = new Viewer(container, {
        inline: false,
        viewed() {
            viewer.zoomTo(0.5);
        },
        title: [true, (image, imageData) => {
            return container.dataset.title;
        }],
        toolbar: {
            zoomIn: true,
            zoomOut: true,
            oneToOne: true,
            reset: true,
            prev: false,
            next: false,
            rotateLeft: true,
            rotateRight: true,
            flipHorizontal: true,
            flipVertical: true,
            play: false,
        },
        navbar: false,
        initialViewIndex: 0,
        minZoomRatio: 0.1,
        maxZoomRatio: 4,
    });
});
</script>
@endpush
@endsection 