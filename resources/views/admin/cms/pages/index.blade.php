<x-layouts.app title="CMS — Pages">
    <div class="space-y-6" x-data="{ showModal: false }">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Pages du site</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez les pages et sections de votre site</p>
            </div>
            <x-ui.button @click="showModal = true">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Nouvelle page
            </x-ui.button>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Page</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sections</th>
                        <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ $loop->even ? 'bg-gray-50/30' : '' }}">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.cms.pages.show', $page) }}" class="font-semibold text-gray-900 hover:text-royal-600 transition-colors">{{ $page->title }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-mono">/{{ $page->slug }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-600 font-medium">{{ $page->sections_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-ui.badge :variant="$page->is_active ? 'success' : 'default'">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cms.pages.show', $page) }}" class="text-royal-600 hover:text-royal-800 text-sm font-semibold transition-colors">Éditer</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-gray-400 text-sm font-medium">Aucune page</p>
                                <p class="text-gray-300 text-xs mt-1">Créez votre première page pour commencer</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal création page --}}
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display:none;" @keydown.escape.window="showModal = false">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl" x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" @click.outside="showModal = false">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Nouvelle page</h2>
                <p class="text-sm text-gray-500 mb-6">Ajoutez une nouvelle page à votre site</p>
                <form method="POST" action="{{ route('admin.cms.pages.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <x-ui.input name="title" label="Titre" placeholder="Accueil, Services, À propos..." :required="true" />
                        <x-ui.input name="slug" label="Slug (auto-généré si vide)" placeholder="mon-url" />
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="showModal = false" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Annuler</button>
                        <x-ui.button type="submit" class="flex-1">Créer</x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
