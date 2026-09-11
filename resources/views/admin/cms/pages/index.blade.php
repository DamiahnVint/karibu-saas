<x-layouts.app title="CMS — Pages">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Pages du site</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez les pages et sections de votre site</p>
            </div>
            <button onclick="document.getElementById('createPageModal').classList.remove('hidden')" class="btn-primary text-white px-4 py-2 rounded-xl font-semibold text-sm">
                + Nouvelle page
            </button>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Page</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Slug</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sections</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.cms.pages.show', $page) }}" class="font-semibold text-gray-900 hover:text-royal-600">{{ $page->title }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-mono">/{{ $page->slug }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-600">{{ $page->sections_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs px-2 py-1 rounded-full {{ $page->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cms.pages.show', $page) }}" class="text-royal-600 hover:text-royal-800 text-sm font-semibold">Éditer</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Aucune page.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="createPageModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Nouvelle page</h2>
            <form method="POST" action="{{ route('admin.cms.pages.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre</label>
                        <input type="text" name="title" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Slug (auto-généré si vide)</label>
                        <input type="text" name="slug" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500" placeholder="mon-url">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('createPageModal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold text-sm">Annuler</button>
                    <button type="submit" class="flex-1 btn-primary text-white py-2.5 rounded-xl font-semibold text-sm">Créer</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
