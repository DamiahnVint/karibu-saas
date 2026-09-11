<x-layouts.app title="CMS — Navigation">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-gray-900">Navigation</h1>
            <p class="text-gray-500 text-sm mt-1">Gérez les menus du site (header, footer, mobile)</p>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        @foreach(['header' => 'Menu principal (Header)', 'footer' => 'Pied de page (Footer)', 'mobile' => 'Menu mobile'] as $location => $label)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 mb-4">{{ $label }}</h2>
                <form method="POST" action="{{ route('admin.cms.navigation.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="location" value="{{ $location }}">

                    <div class="space-y-3 nav-items" id="nav-{{ $location }}">
                        @forelse($navigations[$location] as $index => $item)
                            <div class="flex items-center gap-2 nav-item">
                                <span class="text-gray-400 cursor-move">⠿</span>
                                <input type="hidden" name="items[{{ $index }}][order]" value="{{ $index }}">
                                <input type="text" name="items[{{ $index }}][label]" value="{{ $item['label'] }}" placeholder="Label" class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-royal-500">
                                <input type="text" name="items[{{ $index }}][url]" value="{{ $item['url'] }}" placeholder="URL" class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-royal-500 font-mono">
                                <button type="button" onclick="this.closest('.nav-item').remove()" class="text-red-400 hover:text-red-600 text-sm">✕</button>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Aucun élément.</p>
                        @endforelse
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button type="button" onclick="addNavItem('{{ $location }}')" class="text-sm text-royal-600 hover:text-royal-800 font-semibold">+ Ajouter un lien</button>
                        <button type="submit" class="ml-auto btn-primary text-white px-4 py-2 rounded-xl font-semibold text-sm">Sauvegarder</button>
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
            div.className = 'flex items-center gap-2 nav-item';
            div.innerHTML = `
                <span class="text-gray-400 cursor-move">⠿</span>
                <input type="hidden" name="items[${count}][order]" value="${count}">
                <input type="text" name="items[${count}][label]" placeholder="Label" class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-royal-500">
                <input type="text" name="items[${count}][url]" placeholder="URL" class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-royal-500 font-mono">
                <button type="button" onclick="this.closest('.nav-item').remove()" class="text-red-400 hover:text-red-600 text-sm">✕</button>
            `;
            container.appendChild(div);
        }
    </script>
</x-layouts.app>
