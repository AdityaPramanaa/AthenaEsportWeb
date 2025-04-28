@props([
    'title' => '',
    'description' => '',
    'searchPlaceholder' => '',
    'filters' => [],
    'showSearch' => true,
    'showNewsletter' => true,
    'showHero' => true
])

<x-app-layout>
    @if($showHero)
        <x-hero 
            :title="$title"
            :description="$description"
        >
            @if($showSearch)
                <x-search-filter 
                    :searchPlaceholder="$searchPlaceholder"
                    :filters="$filters"
                />
            @endif

            {{ $slot }}
        </x-hero>
    @else
        {{ $slot }}
    @endif

    @if($showNewsletter)
        <x-newsletter />
    @endif
</x-app-layout> 