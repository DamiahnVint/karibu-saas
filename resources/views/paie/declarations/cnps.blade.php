<x-layouts.app :title="'Déclaration CNPS'">
    <div class="mb-6">
        <a href="{{ route('paie.declarations.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour aux déclarations</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Déclaration CNPS — {{ \Carbon\Carbon::create()->month($mois)->translatedFormat('F') }} {{ $annee }}</h1>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
        <h2 class="font-bold text-gray-900 mb-4">Synthèse CNPS</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div><span class="text-gray-500">Retraite employeur (7.70%)</span><div class="font-bold text-lg">{{ number_format($synthese['retraite_employeur'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">Maternité (0.75%)</span><div class="font-bold text-lg">{{ number_format($synthese['maternite'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">PF (5.00%)</span><div class="font-bold text-lg">{{ number_format($synthese['pf'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">AT (2.50%)</span><div class="font-bold text-lg">{{ number_format($synthese['at'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">CMU employeur</span><div class="font-bold">{{ number_format($synthese['cmu_employeur'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">CMU salarié</span><div class="font-bold">{{ number_format($synthese['cmu_salarie'], 0, ',', ' ') }} FCFA</div></div>
            <div><span class="text-gray-500">Retraite salarié (6.30%)</span><div class="font-bold">{{ number_format($synthese['retraite_salarie'], 0, ',', ' ') }} FCFA</div></div>
            <div class="bg-royal-50 rounded-lg p-3"><span class="text-royal-700 font-bold">Total à déclarer</span><div class="font-black text-xl text-royal-900">{{ number_format($synthese['total'], 0, ',', ' ') }} FCFA</div></div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Retraite Sal.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">CMU Sal.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Retraite Emp.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Maternité</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">PF</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">AT</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">CMU Emp.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payslips as $p)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-semibold">{{ $p->employee->prenom ?? '' }} {{ $p->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_retraite_salarie, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_cmu_salarie, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_retraite_employeur, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_maternite, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_pf, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_at, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->cnps_cmu_employeur, 0, ',', ' ') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm">Aucun bulletin validé pour cette période.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
