<x-layouts.app :title="'Clients'" :userName="$userName ?? 'Admin'">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Clients</h1>
                <p class="text-sm text-gray-500">Gérez les abonnements et l'accès des clients.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Entreprise</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Plan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Expire le</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Créé le</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tenants as $tenant)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $tenant->name }}</span>
                            <p class="text-xs text-gray-400">{{ $tenant->slug }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $tenant->subscription?->plan?->name ?? $tenant->plan }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'trialing' => 'bg-blue-100 text-blue-700',
                                    'past_due' => 'bg-yellow-100 text-yellow-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'expired' => 'bg-gray-100 text-gray-700',
                                    'none' => 'bg-gray-100 text-gray-500',
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
                            <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full {{ $statusColors[$tenant->subscription_status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ $statusLabels[$tenant->subscription_status] ?? $tenant->subscription_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $tenant->subscription_ends_at?->format('d/m/Y') ?? $tenant->trial_ends_at?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $tenant->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="text-sm text-royal-600 hover:text-royal-800 font-medium">Détails</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">Aucun client pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
