<x-layouts.app :title="'Feuilles de temps'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Feuilles de temps</h1>
            <p class="text-sm text-gray-500">{{ $timesheets->total() }} entrée(s)</p>
        </div>
        <a href="{{ route('paie.timesheets.create') }}" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">+ Nouvelle entrée</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Date</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Horaires</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Total</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Heures sup.</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($timesheets as $ts)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $ts->employee->prenom ?? '' }} {{ $ts->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $ts->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $ts->heure_debut }} — {{ $ts->heure_fin }}</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ $ts->heures_totales }}h</td>
                            <td class="px-4 py-3 text-right {{ $ts->heures_sup > 0 ? 'text-amber-600 font-semibold' : 'text-gray-400' }}">{{ $ts->heures_sup }}h</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-{{ $ts->statut === 'valide' ? 'green' : 'gray' }}-100 text-{{ $ts->statut === 'valide' ? 'green' : 'gray' }}-700">{{ ucfirst($ts->statut) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Aucune feuille de temps.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($timesheets->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $timesheets->links() }}</div>
        @endif
    </div>
</x-layouts.app>
