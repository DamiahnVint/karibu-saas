<x-layouts.app title="CMS — Formulaires">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Formulaires</h1>
                <p class="text-gray-500 text-sm mt-1">Soumissions de contact et demandes de démo</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        {{-- Tabs --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.cms.forms.index', ['type' => 'contact']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ $type === 'contact' ? 'bg-royal-600 text-white shadow-md shadow-royal-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Contact {{ $type === 'contact' ? "($unreadCount)" : '' }}
            </a>
            <a href="{{ route('admin.cms.forms.index', ['type' => 'demo']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ $type === 'demo' ? 'bg-royal-600 text-white shadow-md shadow-royal-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Démo
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Données</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($submissions as $sub)
                        <tr class="hover:bg-gray-50/50 transition-colors {{ !$sub->is_read ? 'bg-amber-50/30' : ($loop->even ? 'bg-gray-50/30' : '') }}">
                            <td class="px-6 py-4">
                                @if(!$sub->is_read)
                                    <span class="w-2.5 h-2.5 bg-amber-400 rounded-full inline-block ring-4 ring-amber-50"></span>
                                @else
                                    <span class="w-2.5 h-2.5 bg-gray-200 rounded-full inline-block"></span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.cms.forms.show', $sub) }}" class="font-semibold text-gray-900 hover:text-royal-600 text-sm transition-colors">
                                    {{ $sub->data['name'] ?? $sub->data['email'] ?? 'N/A' }}
                                </a>
                                <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($sub->data['message'] ?? $sub->data['subject'] ?? '', 80) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $sub->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cms.forms.show', $sub) }}" class="text-royal-600 hover:text-royal-800 text-sm font-semibold transition-colors">Voir</a>
                                <form method="POST" action="{{ route('admin.cms.forms.destroy', $sub) }}" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold transition-colors" onclick="return confirm('Supprimer ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                <p class="text-gray-400 text-sm font-medium">Aucune soumission</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $submissions->withQueryString()->links() }}</div>
    </div>
</x-layouts.app>
