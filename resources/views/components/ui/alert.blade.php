@props([
    'type' => 'info',
    'title' => null,
])

@php
$types = [
    'info' => 'bg-sky-50 text-sky-800 border-sky-200/60',
    'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200/60',
    'warning' => 'bg-amber-50 text-amber-800 border-amber-200/60',
    'error' => 'bg-rose-50 text-rose-800 border-rose-200/60',
];
$icons = [
    'info' => '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
    'success' => '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
    'warning' => '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
    'error' => '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
];
$classes = $types[$type] ?? $types['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-xl border p-4 flex items-start gap-3 $classes"]) }}>
    {!! $icons[$type] ?? $icons['info'] !!}
    <div class="flex-1 min-w-0">
        @if($title)
            <p class="font-semibold text-sm">{{ $title }}</p>
        @endif
        <div class="@if($title) mt-0.5 @endif text-sm opacity-90">
            {{ $slot }}
        </div>
    </div>
</div>
