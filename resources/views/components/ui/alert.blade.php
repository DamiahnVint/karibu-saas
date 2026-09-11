@props([
    'type' => 'info',
    'title' => null,
])

@php
$types = [
    'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    'success' => 'bg-green-50 text-green-800 border-green-200',
    'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
    'error' => 'bg-red-50 text-red-800 border-red-200',
];
$classes = $types[$type] ?? $types['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 $classes"]) }}>
    @if($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif
    <div class="@if($title) mt-1 @endif text-sm">
        {{ $slot }}
    </div>
</div>
