@props([
    'type' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'right',
    'href' => null,
    'submit' => false
])

@php
    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3',
        'lg' => 'px-8 py-4 text-lg'
    ];

    $types = [
        'primary' => 'bg-primary text-white hover:bg-primary-light',
        'secondary' => 'bg-secondary text-white hover:bg-secondary-light',
        'outline' => 'border border-border hover:border-primary hover:text-primary',
        'ghost' => 'hover:bg-surface/20'
    ];
@endphp

@if($href)
    <a href="{{ $href }}" 
       class="btn-animate inline-flex items-center justify-center rounded-lg transition-all {{ $types[$type] }} {{ $sizes[$size] }}">
        @if($icon && $iconPosition === 'left')
            <i class="ri-{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <i class="ri-{{ $icon }} ml-2"></i>
        @endif
    </a>
@else
    <button type="{{ $submit ? 'submit' : 'button' }}"
            class="btn-animate inline-flex items-center justify-center rounded-lg transition-all {{ $types[$type] }} {{ $sizes[$size] }}">
        @if($icon && $iconPosition === 'left')
            <i class="ri-{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <i class="ri-{{ $icon }} ml-2"></i>
        @endif
    </button>
@endif 