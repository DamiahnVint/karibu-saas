<x-layouts.app :title="'Clients'" :userName="$userName ?? 'Admin'">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Clients</h1>
                <p class="text-sm text-gray-500 mt-1">Gérez les abonnements et l'accès des clients.</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Entreprise</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Expire le</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Créé le</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tenants as $tenant)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ $loop->even ? 'bg-gray-50/30' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-to-br from-royal-50 to-royal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-royal-600 font-bold text-sm">{{ strtoupper(substr($tenant->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $tenant->name }}</span>
                                    <p class="text-xs text-gray-400 font-mono">{{ $tenant->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                            {{ $tenant->subscription?->plan?->name ?? $tenant->plan }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusVariants = [
                                    'active' => 'success',
                                    'trialing' => 'info',
                                    'past_due' => 'warning',
                                    'cancelled' => 'danger',
                                    'expired' => 'default',
                                    'none' => 'default',
                                ];
                                $statusLabels = [
                                    'active' => 'Actif',
                                    'trialing' => 'Essai',
                                    'past_due' => 'En retard',
                                    'cancelled' => 'Annulé',
                                    'expired' => 'Expiré',
                                    'none' => 'Aucun',
                                ];
                            @endphp
                            <x-ui.badge :variant="$statusVariants[$tenant->subscription_status] ?? 'default'">
                                {{ $statusLabels[$tenant->subscription_status] ?? $tenant->subscription_status }}
                            </x-ui.badge>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $tenant->subscription_ends_at?->format('d/m/Y') ?? $tenant->trial_ends_at?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $tenant->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="text-sm text-royal-600 hover:text-royal-800 font-semibold transition-colors">Détails</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p class="text-gray-400 text-sm font-medium">Aucun client pour le moment</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
