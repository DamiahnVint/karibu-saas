{{-- CTA SECTION --}}
<section id="contact" class="py-24 relative">
    <div class="filigrane"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-6">{{ $section['content']['title'] ?? '' }}</h2>
        @if(!empty($section['content']['description']))
            <p class="text-xl text-white/70 mb-10 max-w-2xl mx-auto">{{ $section['content']['description'] }}</p>
        @endif
        @if(!empty($section['content']['cta_text']))
            <a href="{{ $section['content']['cta_url'] ?? '#' }}" class="inline-block btn-primary text-white px-8 py-4 rounded-xl font-bold text-lg">
                {{ $section['content']['cta_text'] }}
            </a>
        @endif
    </div>
</section>
