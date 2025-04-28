@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-center mb-4">Event Athena E-Sport</h1>
        <p class="text-gray-900 text-center">Ikuti berbagai event menarik dari Athena E-Sport</p>
    </div>

    <!-- Filter Section -->
    <x-search-filter 
        searchPlaceholder="Cari event..."
        :filters="[
            ['value' => '', 'label' => 'Semua Kategori'],
            ['value' => 'kampus', 'label' => 'Kampus'],
            ['value' => 'luar kampus', 'label' => 'Luar Kampus']
        ]"
        :types="[
            ['value' => '', 'label' => 'Semua Tipe'],
            ['value' => 'tournament', 'label' => 'Tournament'],
            ['value' => 'gathering', 'label' => 'Gathering'],
            ['value' => 'workshop', 'label' => 'Workshop']
        ]"
    />

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
                <div class="relative">
                    <img src="{{ Storage::url($event->poster_path) }}" 
                         alt="{{ $event->title }}"
                         class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 text-sm font-medium rounded-full 
                            {{ $event->category == 'kampus' ? 'bg-gradient-to-r from-blue-500 to-blue-700 text-white' : 'bg-green-500 text-white' }}">
                            {{ ucfirst($event->category) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2 text-gray-900">{{ $event->title }}</h3>
                    
                    <div class="space-y-2 text-sm text-gray-900 mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt w-5"></i>
                            {{ $event->getFormattedEventDateAttribute() }}
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock w-5"></i>
                            {{ $event->getFormattedEventTimeAttribute() }}
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            {{ $event->location }}
                        </div>
                    </div>

                    <p class="text-gray-900 text-sm mb-4">
                        {{ Str::limit($event->description, 100) }}
                    </p>

                    <div class="flex items-center justify-between pt-4 border-t">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white">
                            {{ ucfirst($event->type) }}
                        </span>
                        <a href="{{ route('events.show', $event) }}" 
                           class="text-gray-900 hover:text-gray-700 font-medium text-sm">
                            Detail Event →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-blue-50 text-blue-700 p-4 rounded-lg flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Tidak ada event yang tersedia saat ini.</span>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $events->withQueryString()->links() }}
        </div>
    @endif

    <!-- Newsletter -->
    <div class="mt-16 bg-gray-50 rounded-xl p-8 text-center">
        <h2 class="text-2xl font-bold mb-2 text-gray-900">Jangan Lewatkan Event Terbaru</h2>
        <p class="text-gray-900 mb-6">Dapatkan informasi event terbaru langsung di inbox kamu</p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" 
                   placeholder="Masukkan email kamu" 
                   class="flex-1 px-4 py-2 rounded-lg border focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-lg hover:opacity-90 transition-all">
                Berlangganan
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.pagination {
    margin-bottom: 0;
}
</style>
@endpush
@endsection