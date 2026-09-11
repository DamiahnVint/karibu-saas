<x-layouts.app :title="'Gestion des plans'" :userName="$userName ?? 'Admin'">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Plans & Tarifs</h1>
                <p class="text-sm text-gray-500">Gérez les plans d'abonnement affichés sur le site.</p>
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
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Ordre</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Prix</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Employés</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Cycle</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($plans as $plan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $plan->sort_order }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $plan->name }}</span>
                            @if($plan->is_trial)
                                <span class="ml-2 text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Essai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $plan->price > 0 ? number_format($plan->price, 0, ',', ' ') . ' XOF' : 'Gratuit' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->max_employees }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->billing_cycle === 'monthly' ? 'Mensuel' : 'Annuel' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-xs font-medium {{ $plan->is_active ? 'text-green-700' : 'text-red-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $plan->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="text-sm text-royal-600 hover:text-royal-800 font-medium">Modifier</a>
                            <form method="POST" action="{{ route('admin.plans.toggle', $plan) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm {{ $plan->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }} font-medium">
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
