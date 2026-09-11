{{-- TESTIMONIALS SECTION --}}
<section class="py-24 relative bg-gray-50">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900">{{ $section['title'] }}</h2>
            </div>
        @endif
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($section['content']['items'] ?? [] as $item)
                <div class="bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="flex items-center gap-4 mb-4">
                        @if(!empty($item['avatar']))
                            <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-royal-100 rounded-full flex items-center justify-center">
                                <span class="text-royal-600 font-bold">{{ substr($item['name'] ?? 'U', 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <div class="font-bold text-gray-900">{{ $item['name'] ?? '' }}</div>
                            <div class="text-sm text-gray-500">{{ $item['company'] ?? '' }}</div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"{{ $item['quote'] ?? '' }}"</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
