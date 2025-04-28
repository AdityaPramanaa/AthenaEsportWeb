@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-home"></i>
                </a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-blue-600">Events</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900">{{ $event->title }}</span>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Event Image -->
                    <div class="relative h-[400px] group cursor-zoom-in">
                        <a href="{{ Storage::url($event->poster_path) }}" 
                           data-fancybox="event-image"
                           data-caption="{{ $event->title }}">
                            <img src="{{ Storage::url($event->poster_path) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="fas fa-search-plus text-3xl"></i>
                                </span>
                            </div>
                        </a>
                        <div class="absolute top-4 right-4 space-y-2">
                            <span class="inline-block px-4 py-2 text-sm font-medium rounded-full 
                                {{ $event->category == 'kampus' ? 'bg-gradient-to-r from-blue-500 to-blue-700' : 'bg-gradient-to-r from-green-500 to-green-700' }} 
                                text-white shadow-lg">
                                {{ ucfirst($event->category) }}
                            </span>
                        </div>
                    </div>

                    <!-- Event Content -->
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                        
                        <div class="flex flex-wrap gap-4 mb-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                                <i class="fas fa-trophy mr-2"></i>
                                {{ ucfirst($event->type) }}
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $event->getFormattedEventDateAttribute() }}
                            </span>
                            <span class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $event->getFormattedEventTimeAttribute() }}
                            </span>
                        </div>

                        <div class="prose prose-lg max-w-none">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Event</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Lokasi</h4>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Tanggal</h4>
                                <p class="text-gray-600">{{ $event->getFormattedEventDateAttribute() }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Waktu</h4>
                                <p class="text-gray-600">{{ $event->getFormattedEventTimeAttribute() }}</p>
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t">
                            <a href="#" class="block w-full px-6 py-3 text-center font-medium text-white bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg hover:opacity-90 transition-all">
                                Daftar Event
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Events -->
        @if($relatedEvents->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Event Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedEvents as $relatedEvent)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative">
                        <img src="{{ Storage::url($relatedEvent->poster_path) }}" 
                             alt="{{ $relatedEvent->title }}"
                             class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                {{ $relatedEvent->category == 'kampus' ? 'bg-gradient-to-r from-blue-500 to-blue-700' : 'bg-gradient-to-r from-green-500 to-green-700' }} 
                                text-white">
                                {{ ucfirst($relatedEvent->category) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2 text-gray-900">{{ $relatedEvent->title }}</h3>
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $relatedEvent->getFormattedEventDateAttribute() }}
                        </div>
                        <a href="{{ route('events.show', $relatedEvent) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm group">
                            Detail Event
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform duration-200 transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .prose img {
        border-radius: 0.75rem;
    }
</style>
@endpush
@endsection 