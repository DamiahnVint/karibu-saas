{{-- PRICING SECTION --}}
<section id="pricing" class="py-24 relative">
    <div class="filigrane-light"></div>
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
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($section['content']['plans'] ?? [] as $plan)
                <div class="bg-white rounded-3xl p-8 border {{ ($plan['is_popular'] ?? false) ? 'bg-gradient-to-br from-royal-600 to-royal-800 text-white relative overflow-hidden shadow-2xl scale-105' : 'border-gray-100' }} transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    @if($plan['is_popular'] ?? false)
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-bl-full"></div>
                    @endif
                    <div class="relative">
                        <div class="text-sm font-semibold uppercase tracking-wider mb-2 {{ ($plan['is_popular'] ?? false) ? 'text-white/60' : 'text-gray-400' }}">{{ $plan['name'] ?? '' }}</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-4xl font-black">{{ $plan['price'] ?? '0' }}</span>
                            <span class="{{ ($plan['is_popular'] ?? false) ? 'text-white/60' : 'text-gray-400' }}">{{ $plan['period'] ?? 'FCFA/mois' }}</span>
                        </div>
                        @if(!empty($plan['description']))
                            <p class="{{ ($plan['is_popular'] ?? false) ? 'text-white/60' : 'text-gray-500' }} text-sm mb-6">{{ $plan['description'] }}</p>
                        @endif
                        <a href="{{ $plan['cta_url'] ?? route('checkout.index') }}?plan={{ $plan['slug'] ?? '' }}" class="block w-full text-center py-3 rounded-xl font-bold mb-8 transition {{ ($plan['is_popular'] ?? false) ? 'bg-white text-royal-700 hover:bg-white/90' : 'border-2 border-royal-600 text-royal-600 hover:bg-royal-600 hover:text-white' }}">{{ $plan['cta_text'] ?? 'Commencer' }}</a>
                        <ul class="space-y-3">
                            @foreach($plan['features'] ?? [] as $feature)
                                <li class="flex items-center gap-3 text-sm {{ ($plan['is_popular'] ?? false) ? 'text-white/80' : 'text-gray-600' }}">
                                    <svg class="w-5 h-5 flex-shrink-0 {{ ($plan['is_popular'] ?? false) ? 'text-green-400' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('pricing') }}" class="text-royal-600 font-semibold hover:text-royal-800 transition">Voir tous les tarifs &rarr;</a>
            <span class="mx-4 text-gray-300">|</span>
            <a href="{{ route('demo.index') }}" class="text-royal-600 font-semibold hover:text-royal-800 transition">Réserver une démo</a>
        </div>
    </div>
</section>
