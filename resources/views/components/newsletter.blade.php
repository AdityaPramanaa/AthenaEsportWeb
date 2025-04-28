@props([
    'title' => 'Jangan Lewatkan Update Terbaru',
    'description' => 'Dapatkan informasi terbaru langsung di inbox kamu',
    'buttonText' => 'Subscribe'
])

<section class="py-20 bg-surface relative overflow-hidden">
    <div class="absolute inset-0 animated-gradient opacity-10"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-2xl mx-auto text-center" data-aos="zoom-in">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">{{ $title }}</h2>
            <p class="text-text-secondary text-lg mb-8">
                {{ $description }}
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" 
                       placeholder="Masukkan email kamu" 
                       class="flex-1 px-5 py-3 bg-background border border-border rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                <button type="submit" class="btn-animate px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-all">
                    {{ $buttonText }}
                </button>
            </form>
        </div>
    </div>
</section> 