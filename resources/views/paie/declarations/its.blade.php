<x-layouts.app :title="'Déclaration ITS'">
    <div class="mb-6">
        <a href="{{ route('paie.declarations.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour aux déclarations</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Déclaration ITS — {{ \Carbon\Carbon::create()->month($mois)->translatedFormat('F') }} {{ $annee }}</h1>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Brut</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Base (80%)</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">ITS brut</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Crédit</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">ITS retenu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payslips as $p)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-semibold">{{ $p->employee->prenom ?? '' }} {{ $p->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->total_brut, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->its_base, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($p->its_brut, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-green-600">-{{ number_format($p->its_credit, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold text-purple-700">{{ number_format($p->its_net, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Aucun bulletin validé pour cette période.</td></tr>
                    @endforelse
                </tbody>
                @if($payslips->isNotEmpty())
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 bg-gray-50">
                            <td class="px-4 py-3 font-bold">TOTAL</td>
                            <td class="px-4 py-3 text-right font-bold">{{ number_format($payslips->sum('total_brut'), 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold">{{ number_format($payslips->sum('its_base'), 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold">{{ number_format($payslips->sum('its_brut'), 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold text-green-600">-{{ number_format($payslips->sum('its_credit'), 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-black text-purple-900">{{ number_format($payslips->sum('its_net'), 0, ',', ' ') }} FCFA</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-layouts.app>
