{{-- FAQ SECTION --}}
<section class="py-24 relative">
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <h2 class="text-3xl font-black text-gray-900 mb-8 text-center">{{ $section['title'] }}</h2>
        @endif
        <div class="space-y-4">
            @foreach($section['content']['items'] ?? [] as $item)
                <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $item['question'] ?? '' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600">{{ $item['answer'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
