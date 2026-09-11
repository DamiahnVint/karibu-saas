<x-layouts.app :title="'Déclarations'">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Déclarations sociales & fiscales</h1>
        <p class="text-sm text-gray-500">CNPS & ITS — {{ \Carbon\Carbon::create()->month($mois)->translatedFormat('F') }} {{ $annee }}</p>
    </div>

    <form method="GET" class="bg-white rounded-xl border border-gray-100 p-4 mb-6 flex gap-3">
        <select name="mois" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $mois == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
            @endfor
        </select>
        <select name="annee" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ $annee == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">Afficher</button>
    </form>

    {{-- Résumé --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5">
            <div class="text-xs text-gray-500 mb-1">Employés déclarés</div>
            <div class="text-xl font-bold text-gray-900">{{ $summary['total_employes'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5">
            <div class="text-xs text-gray-500 mb-1">CNPS employeur</div>
            <div class="text-xl font-bold text-gray-900">{{ number_format($summary['total_cnps_employeur'], 0, ',', ' ') }}</div>
            <div class="text-[10px] text-gray-400">FCFA</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5">
            <div class="text-xs text-gray-500 mb-1">ITS retenu</div>
            <div class="text-xl font-bold text-gray-900">{{ number_format($summary['total_its_retenu'], 0, ',', ' ') }}</div>
            <div class="text-[10px] text-gray-400">FCFA</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5">
            <div class="text-xs text-gray-500 mb-1">Total nets à payer</div>
            <div class="text-xl font-bold text-gray-900">{{ number_format($summary['total_net_a_payer'], 0, ',', ' ') }}</div>
            <div class="text-[10px] text-gray-400">FCFA</div>
        </div>
    </div>

    {{-- Liens rapides --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <a href="{{ route('paie.declarations.cnps', ['mois' => $mois, 'annee' => $annee]) }}" class="bg-white rounded-xl border border-gray-100 p-5 hover:border-royal-300 transition">
            <div class="font-bold text-gray-900">Déclaration CNPS</div>
            <div class="text-sm text-gray-500 mt-1">Synthèse retraite, maternité, PF, AT, CMU</div>
        </a>
        <a href="{{ route('paie.declarations.its', ['mois' => $mois, 'annee' => $annee]) }}" class="bg-white rounded-xl border border-gray-100 p-5 hover:border-royal-300 transition">
            <div class="font-bold text-gray-900">Déclaration ITS</div>
            <div class="text-sm text-gray-500 mt-1">Retenue à la source par employé</div>
        </a>
    </div>

    {{-- Tableau récapitulatif --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Récapitulatif par employé</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Brut</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">CNPS Sal.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">CNPS Emp.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">ITS</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Net</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payslips as $payslip)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $payslip->employee->prenom ?? '' }} {{ $payslip->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($payslip->total_brut, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-red-600">{{ number_format($payslip->total_cnps_salarie, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-amber-600">{{ number_format($payslip->total_cnps_employeur, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-purple-600">{{ number_format($payslip->its_net, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold">{{ number_format($payslip->net_a_payer, 0, ',', ' ') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">Aucun bulletin validé pour cette période.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
