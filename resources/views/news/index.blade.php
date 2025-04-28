@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Berita Terbaru</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($news as $item)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="image-container" data-title="{{ $item->title }}">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="news-image w-full h-48 object-cover hover:opacity-75 transition-opacity cursor-pointer">
            </div>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $item->title }}</h2>
                <p class="text-gray-600 mb-4">
                    {{ Str::limit(strip_tags($item->content), 150) }}
                </p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">
                        {{ $item->created_at->format('d M Y') }}
                    </span>
                    <a href="{{ route('news.show', $item->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $news->links() }}
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
    const containers = document.querySelectorAll('.image-container');
    containers.forEach(container => {
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
});
</script>
@endpush
@endsection 