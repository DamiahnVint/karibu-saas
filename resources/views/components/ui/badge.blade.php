@props([
    'variant' => 'default',
])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-600',
    'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/60',
    'warning' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60',
    'danger' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/60',
    'info' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/60',
    'primary' => 'bg-royal-50 text-royal-700 ring-1 ring-royal-200/60',
];
$classes = $variants[$variant] ?? $variants['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold $classes"]) }}>
    {{ $slot }}
</span>
