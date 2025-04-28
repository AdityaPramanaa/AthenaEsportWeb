@props([
    'columns' => '1 md:grid-cols-2 lg:grid-cols-3',
    'gap' => '8'
])

<div class="grid grid-cols-{{ $columns }} gap-{{ $gap }}">
    {{ $slot }}
</div> 