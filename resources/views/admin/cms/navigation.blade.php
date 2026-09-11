<x-layouts.app title="CMS — Navigation">
    <div class="max-w-4xl space-y-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Navigation</h1>
            <p class="text-gray-500 text-sm mt-1">Gérez les menus du site (header, footer, mobile)</p>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        @foreach(['header' => 'Menu principal (Header)', 'footer' => 'Pied de page (Footer)', 'mobile' => 'Menu mobile'] as $location => $label)
            <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
                <h2 class="font-bold text-gray-900 mb-5">{{ $label }}</h2>
                <form method="POST" action="{{ route('admin.cms.navigation.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="location" value="{{ $location }}">

                    <div class="space-y-3 nav-items" id="nav-{{ $location }}">
                        @forelse($navigations[$location] as $index => $item)
                            <div class="flex items-center gap-2 nav-item group">
                                <span class="text-gray-300 cursor-move hover:text-gray-500 transition-colors">⠿</span>
                                <input type="hidden" name="items[{{ $index }}][order]" value="{{ $index }}">
                                <input type="text" name="items[{{ $index }}][label]" value="{{ $item['label'] }}" placeholder="Label" class="flex-1 rounded-xl border-gray-200 bg-gray-50/50 px-3 py-2 text-sm focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 transition-all">
                                <input type="text" name="items[{{ $index }}][url]" value="{{ $item['url'] }}" placeholder="URL" class="flex-1 rounded-xl border-gray-200 bg-gray-50/50 px-3 py-2 text-sm focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 font-mono transition-all">
                                <button type="button" onclick="this.closest('.nav-item').remove()" class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Aucun élément.</p>
                        @endforelse
                    </div>

                    <div class="flex gap-3 mt-5">
                        <button type="button" onclick="addNavItem('{{ $location }}')" class="text-sm text-royal-600 hover:text-royal-800 font-semibold transition-colors inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Ajouter un lien
                        </button>
                        <x-ui.button type="submit" class="ml-auto">Sauvegarder</x-ui.button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        function addNavItem(location) {
            const container = document.getElementById('nav-' + location);
            const count = container.querySelectorAll('.nav-item').length;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 nav-item group';
            div.innerHTML = `
                <span class="text-gray-300 cursor-move hover:text-gray-500 transition-colors">⠿</span>
                <input type="hidden" name="items[${count}][order]" value="${count}">
                <input type="text" name="items[${count}][label]" placeholder="Label" class="flex-1 rounded-xl border-gray-200 bg-gray-50/50 px-3 py-2 text-sm focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 transition-all">
                <input type="text" name="items[${count}][url]" placeholder="URL" class="flex-1 rounded-xl border-gray-200 bg-gray-50/50 px-3 py-2 text-sm focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 font-mono transition-all">
                <button type="button" onclick="this.closest('.nav-item').remove()" class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</x-layouts.app>
