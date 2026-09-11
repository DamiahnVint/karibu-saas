{{-- CONTACT SECTION --}}
<section class="py-24 relative bg-gray-50">
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['title']))
            <h2 class="text-3xl font-black text-gray-900 mb-6 text-center">{{ $section['title'] }}</h2>
        @endif
        <form action="{{ route('cms.form.store', 'contact') }}" method="POST" class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-royal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-royal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Message</label>
                    <textarea name="message" rows="5" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-royal-500 resize-none"></textarea>
                </div>
                <button type="submit" class="w-full btn-primary text-white py-3 rounded-xl font-bold">{{ $section['content']['submit_text'] ?? 'Envoyer' }}</button>
            </div>
        </form>
    </div>
</section>
