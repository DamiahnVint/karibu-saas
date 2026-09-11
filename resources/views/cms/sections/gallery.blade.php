{{-- GALLERY SECTION --}}
<section class="py-24 relative">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <h2 class="text-3xl font-black text-gray-900 mb-8 text-center">{{ $section['title'] }}</h2>
        @endif
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($section['content']['items'] ?? [] as $item)
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                    @if(!empty($item['media_url']))
                        <img src="{{ $item['media_url'] }}" alt="{{ $item['caption'] ?? '' }}" class="w-full h-full object-cover hover:scale-105 transition">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
