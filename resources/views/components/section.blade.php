@props([
    'title' => '',
    'description' => '',
    'padding' => 'py-20',
    'background' => 'bg-surface',
    'gradient' => true
])

<section class="{{ $padding }} {{ $background }} relative overflow-hidden">
    @if($gradient)
        <div class="absolute inset-0 animated-gradient opacity-10"></div>
    @endif
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        @if($title || $description)
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                @if($title)
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">
                        <span class="gradient-text">{{ $title }}</span>
                    </h2>
                @endif
                @if($description)
                    <p class="text-text-secondary text-lg md:text-xl text-balance">
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</section> 