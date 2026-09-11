<x-layouts.app :title="'Employés'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Employés</h1>
            <p class="text-sm text-gray-500">{{ $employees->total() }} employé(s) au total</p>
        </div>
        <a href="{{ route('paie.employees.create') }}" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
            + Nouvel employé
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-white rounded-xl border border-gray-100 p-4 mb-6 flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="flex-1 min-w-[200px] px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500 focus:border-transparent">
        <select name="statut" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les statuts</option>
            <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actif</option>
            <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
            <option value="suspendu" {{ request('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
            <option value="radie" {{ request('statut') === 'radie' ? 'selected' : '' }}>Radié</option>
        </select>
        <select name="department_id" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les départements</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">Filtrer</button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Matricule</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Nom complet</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Poste</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Département</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Salaire</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Statut</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $employee->matricule }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-royal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-royal-700 font-bold text-xs">{{ strtoupper(substr($employee->prenom, 0, 1)) }}</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $employee->poste ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $employee->department?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ number_format($employee->salaire_base, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full
                                    {{ match($employee->statut) {
                                        'actif' => 'bg-green-100 text-green-700',
                                        'inactif' => 'bg-gray-100 text-gray-600',
                                        'suspendu' => 'bg-amber-100 text-amber-700',
                                        'radie' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    } }}">
                                    {{ \App\Enums\Paie\EmployeeStatut::tryFrom($employee->statut)?->label() ?? $employee->statut }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('paie.employees.show', $employee->id) }}" class="text-royal-600 hover:text-royal-800 text-xs font-semibold">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">
                                Aucun employé trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
