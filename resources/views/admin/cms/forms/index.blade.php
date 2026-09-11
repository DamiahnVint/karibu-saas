<x-layouts.app title="CMS — Formulaires">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Formulaires</h1>
                <p class="text-gray-500 text-sm mt-1">Soumissions de contact et demandes de démo</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="flex gap-2 mb-6">
            <a href="{{ route('admin.cms.forms.index', ['type' => 'contact']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $type === 'contact' ? 'bg-royal-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Contact {{ $type === 'contact' ? "($unreadCount)" : '' }}
            </a>
            <a href="{{ route('admin.cms.forms.index', ['type' => 'demo']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $type === 'demo' ? 'bg-royal-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Démo
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Données</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($submissions as $sub)
                        <tr class="hover:bg-gray-50 transition {{ !$sub->is_read ? 'bg-orange-50/30' : '' }}">
                            <td class="px-6 py-4">
                                @if(!$sub->is_read)
                                    <span class="w-2 h-2 bg-orange-500 rounded-full inline-block"></span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.cms.forms.show', $sub) }}" class="font-semibold text-gray-900 hover:text-royal-600 text-sm">
                                    {{ $sub->data['name'] ?? $sub->data['email'] ?? 'N/A' }}
                                </a>
                                <div class="text-xs text-gray-400">{{ Str::limit($sub->data['message'] ?? $sub->data['subject'] ?? '', 80) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cms.forms.show', $sub) }}" class="text-royal-600 hover:text-royal-800 text-sm font-semibold">Voir</a>
                                <form method="POST" action="{{ route('admin.cms.forms.destroy', $sub) }}" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Aucune soumission.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $submissions->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
