{{-- TEXT SECTION --}}
<section class="py-16 relative">
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <h2 class="text-3xl font-black text-gray-900 mb-6">{{ $section['title'] }}</h2>
        @endif
        <div class="prose prose-lg max-w-none text-gray-700">
            {!! $section['content']['html_content'] ?? '' !!}
        </div>
    </div>
</section>
