{{-- FEATURES SECTION --}}
<section id="produits" class="py-24 relative">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <div class="text-center mb-16">
                <span class="text-royal-600 font-semibold text-sm uppercase tracking-wider">{{ $section['title'] }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3 mb-4">{{ $section['content']['subtitle'] ?? '' }}</h2>
                @if(!empty($section['content']['description']))
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ $section['content']['description'] }}</p>
                @endif
            </div>
        @endif
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($section['content']['items'] ?? [] as $item)
                <div class="bg-white rounded-3xl p-8 border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    @if(!empty($item['icon']))
                        <div class="w-14 h-14 bg-royal-100 rounded-2xl flex items-center justify-center mb-6">
                            <span class="text-2xl">{{ $item['icon'] }}</span>
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item['title'] ?? '' }}</h3>
                    <p class="text-gray-500 leading-relaxed">{{ $item['description'] ?? '' }}</p>
                    @if(!empty($item['url']))
                        <a href="{{ $item['url'] }}" class="mt-4 inline-flex items-center gap-2 text-royal-600 font-semibold hover:text-royal-800 transition text-sm">
                            En savoir plus
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
