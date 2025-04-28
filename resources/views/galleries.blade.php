@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center" style="font-family: 'Poppins', sans-serif;">
            Gallery Athena Esport
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($galleries as $gallery)
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-105">
                    <div class="relative h-48">
                        <img src="{{ Storage::url($gallery->image_path) }}" 
                             alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover">
                        @if($gallery->event)
                            <div class="absolute top-2 right-2">
                                <span class="bg-blue-500 text-white px-2 py-1 rounded-md text-sm">
                                    {{ $gallery->event->title }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">
                            {{ $gallery->title }}
                        </h3>
                        <p class="text-gray-600 text-sm" style="font-family: 'Poppins', sans-serif;">
                            {{ Str::limit($gallery->description, 100) }}
                        </p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-gray-500 text-sm">
                                {{ $gallery->created_at->format('d M Y') }}
                            </span>
                            @if($gallery->status === 'published')
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                    Published
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 text-lg" style="font-family: 'Poppins', sans-serif;">
                        Belum ada foto di gallery.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection 