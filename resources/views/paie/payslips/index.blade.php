<x-layouts.app :title="'Bulletins de paie'">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Bulletins de paie</h1>
            <p class="text-sm text-gray-500">{{ $payslips->total() }} bulletin(s)</p>
        </div>
        <a href="{{ route('paie.payslips.create') }}" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
            + Générer un bulletin
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="bg-white rounded-xl border border-gray-100 p-4 mb-6 flex gap-3 flex-wrap">
        <select name="mois" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les mois</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('mois') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
            @endfor
        </select>
        <select name="annee" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ request('annee', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <select name="statut" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
            <option value="">Tous les statuts</option>
            <option value="brouillon" {{ request('statut') === 'brouillon' ? 'selected' : '' }}>Brouillon</option>
            <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>Validé</option>
            <option value="paye" {{ request('statut') === 'paye' ? 'selected' : '' }}>Payé</option>
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">Filtrer</button>
    </form>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Employé</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Période</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Brut</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">CNPS Sal.</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">ITS</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Net à payer</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Statut</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payslips as $payslip)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $payslip->employee->prenom ?? '' }} {{ $payslip->employee->nom ?? '' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $payslip->moisLabel() }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($payslip->total_brut, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($payslip->total_cnps_salarie, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($payslip->its_net, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">{{ number_format($payslip->net_a_payer, 0, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-{{ $payslip->status()->color() }}-100 text-{{ $payslip->status()->color() }}-700">{{ $payslip->status()->label() }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('paie.payslips.show', $payslip->id) }}" class="text-royal-600 hover:text-royal-800 text-xs font-semibold">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm">Aucun bulletin trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payslips->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $payslips->links() }}</div>
        @endif
    </div>
</x-layouts.app>
