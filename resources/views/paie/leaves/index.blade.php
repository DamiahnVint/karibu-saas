<x-layouts.app :title="'Congés'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Congés & Absences</h1>
            <p class="text-sm text-gray-500">{{ $leaves->total() }} demande(s)</p>
        </div>
        <a href="{{ route('paie.leaves.create') }}" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">+ Nouvelle demande</a>
    </div>

    <form method="GET" class="bg-white rounded-xl border border-gray-100 p-4 mb-6 flex gap-3 flex-wrap">
        <select name="statut" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les statuts</option>
            <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="approuve" {{ request('statut') === 'approuve' ? 'selected' : '' }}>Approuvé</option>
            <option value="rejette" {{ request('statut') === 'rejette' ? 'selected' : '' }}>Rejeté</option>
        </select>
        <select name="type" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les types</option>
            <option value="paye" {{ request('type') === 'paye' ? 'selected' : '' }}>Congé payé</option>
            <option value="maladie" {{ request('type') === 'maladie' ? 'selected' : '' }}>Maladie</option>
            <option value="maternite" {{ request('type') === 'maternite' ? 'selected' : '' }}>Maternité</option>
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">Filtrer</button>
    </form>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Type</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Période</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Jours</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Statut</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($leaves as $leave)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $leave->employee->prenom ?? '' }} {{ $leave->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $leave->typeEnum()->label() }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $leave->date_debut->format('d/m') }} — {{ $leave->date_fin->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center font-semibold">{{ $leave->nb_jours }}j</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-{{ $leave->statutEnum()->color() }}-100 text-{{ $leave->statutEnum()->color() }}-700">{{ $leave->statutEnum()->label() }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($leave->statut === 'en_attente')
                                    <div class="flex gap-1 justify-center">
                                        <form method="POST" action="{{ route('paie.leaves.approve', $leave->id) }}">
                                            @csrf
                                            <input type="hidden" name="approved" value="1">
                                            <button class="text-green-600 hover:text-green-800 text-xs font-semibold px-2 py-1 rounded bg-green-50">✓</button>
                                        </form>
                                        <form method="POST" action="{{ route('paie.leaves.approve', $leave->id) }}">
                                            @csrf
                                            <input type="hidden" name="approved" value="0">
                                            <button class="text-red-600 hover:text-red-800 text-xs font-semibold px-2 py-1 rounded bg-red-50">✗</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Aucune demande de congé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leaves->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $leaves->links() }}</div>
        @endif
    </div>
</x-layouts.app>
