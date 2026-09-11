@props([
    'title' => null,
    'subtitle' => null,
    'hover' => false,
])

@php
$base = 'bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 transition-all duration-200';
$hoverClass = $hover ? 'hover:shadow-md hover:-translate-y-0.5 hover:border-royal-200/50 cursor-pointer' : '';
$classes = $base . ' ' . $hoverClass;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title)
        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
            @if($subtitle)
                <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
