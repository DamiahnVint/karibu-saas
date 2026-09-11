{{-- HERO SECTION --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-royal-950 via-royal-900 to-royal-800">
    <div class="filigrane"></div>
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-royal-500/10 rounded-full blur-3xl float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl float" style="animation-delay: -3s;"></div>
    </div>
    <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
        @if(!empty($section['content']['badge']))
            <div class="fade-in-up mb-6" style="animation-delay: 0.2s;">
                <span class="inline-block bg-white/10 border border-white/20 rounded-full px-5 py-2 text-sm text-white/80 backdrop-blur-sm">{{ $section['content']['badge'] }}</span>
            </div>
        @endif
        <h1 class="fade-in-up text-5xl md:text-7xl font-black text-white leading-tight mb-6" style="animation-delay: 0.4s;">
            {!! $section['content']['title'] ?? '' !!}
        </h1>
        @if(!empty($section['content']['subtitle']))
            <p class="fade-in-up text-xl md:text-2xl text-white/70 mb-10 max-w-2xl mx-auto" style="animation-delay: 0.6s;">
                {{ $section['content']['subtitle'] }}
            </p>
        @endif
        <div class="fade-in-up flex flex-col sm:flex-row gap-4 justify-center" style="animation-delay: 0.8s;">
            @if(!empty($section['content']['cta_text']))
                <a href="{{ $section['content']['cta_url'] ?? '#produits' }}" class="btn-primary text-white px-8 py-4 rounded-xl font-bold text-lg">
                    {{ $section['content']['cta_text'] }}
                </a>
            @endif
            @if(!empty($section['content']['cta2_text']))
                <a href="{{ $section['content']['cta2_url'] ?? '#contact' }}" class="border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 transition">
                    {{ $section['content']['cta2_text'] }}
                </a>
            @endif
        </div>
        @if(!empty($section['content']['stats']))
            <div class="fade-in-up grid grid-cols-3 gap-8 mt-16 max-w-lg mx-auto" style="animation-delay: 1s;">
                @foreach($section['content']['stats'] as $stat)
                    <div>
                        <div class="text-3xl font-black text-white">{{ $stat['value'] }}</div>
                        <div class="text-sm text-white/50">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10">
        <a href="#produits" class="text-white/40 hover:text-white/80 transition">
            <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </a>
    </div>
</section>
