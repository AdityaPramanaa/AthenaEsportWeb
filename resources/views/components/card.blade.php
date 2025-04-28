@props([
    'title' => '',
    'description' => '',
    'image' => '',
    'category' => '',
    'date' => '',
    'link' => '#',
    'type' => 'primary'
])

<div class="group" data-aos="fade-up">
    <div class="relative aspect-video rounded-xl overflow-hidden card-hover">
        <img src="{{ $image }}" 
             alt="{{ $title }}"
             class="w-full h-full object-cover transition-transform group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        
        <div class="absolute inset-0 p-6 flex flex-col justify-end">
            <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2 py-1 bg-{{ $type }}/20 backdrop-blur-sm rounded-full text-xs font-medium text-{{ $type }}">
                        {{ $category }}
                    </span>
                    <span class="px-2 py-1 bg-surface/20 backdrop-blur-sm rounded-full text-xs text-white">
                        <i class="ri-calendar-line mr-1"></i> {{ $date }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                <p class="text-gray-300 text-sm mb-4 line-clamp-2">
                    {{ $description }}
                </p>
                <a href="{{ $link }}" class="inline-flex items-center text-white hover:text-primary transition-colors">
                    Baca Selengkapnya
                    <i class="ri-arrow-right-line ml-2 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</div> 