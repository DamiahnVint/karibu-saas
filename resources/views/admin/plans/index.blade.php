<x-layouts.app :title="'Gestion des plans'" :userName="$userName ?? 'Admin'">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Plans & Tarifs</h1>
                <p class="text-sm text-gray-500 mt-1">Gérez les plans d'abonnement affichés sur le site.</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ordre</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employés</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cycle</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($plans as $plan)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ $loop->even ? 'bg-gray-50/30' : '' }}">
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $plan->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $plan->name }}</span>
                                @if($plan->is_trial)
                                    <x-ui.badge variant="info">Essai</x-ui.badge>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            {{ $plan->price > 0 ? number_format($plan->price, 0, ',', ' ') . ' XOF' : 'Gratuit' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->max_employees }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->billing_cycle === 'monthly' ? 'Mensuel' : 'Annuel' }}</td>
                        <td class="px-6 py-4">
                            <x-ui.badge :variant="$plan->is_active ? 'success' : 'danger'">
                                <span class="w-1.5 h-1.5 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-rose-500' }} mr-1"></span>
                                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                            </x-ui.badge>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="text-sm text-royal-600 hover:text-royal-800 font-semibold transition-colors">Modifier</a>
                            <form method="POST" action="{{ route('admin.plans.toggle', $plan) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm {{ $plan->is_active ? 'text-red-500 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-800' }} font-semibold transition-colors">
                                    {{ $plan->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
