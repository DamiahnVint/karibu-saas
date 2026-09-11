<x-layouts.app :title="'Bulletin — ' . $payslip->employee->prenom . ' ' . $payslip->employee->nom">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('paie.payslips.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour</a>
            <h1 class="text-xl font-bold text-gray-900 mt-2">Bulletin de paie — {{ $payslip->moisLabel() }}</h1>
            <p class="text-sm text-gray-500">{{ $payslip->employee->prenom }} {{ $payslip->employee->nom }} ({{ $payslip->employee->matricule }})</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold px-3 py-1 rounded-full bg-{{ $payslip->status()->color() }}-100 text-{{ $payslip->status()->color() }}-700">{{ $payslip->status()->label() }}</span>
            @if($payslip->statut === 'brouillon')
                <form method="POST" action="{{ route('paie.payslips.validate', $payslip->id) }}" class="inline">
                    @csrf
                    <input type="hidden" name="approved" value="1">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">Valider</button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Bulletin --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-4 border-b pb-3">Détail du bulletin</h2>

            {{-- Éléments bruts --}}
            <div class="mb-4">
                <h3 class="text-xs font-bold uppercase text-gray-500 mb-2">Éléments de rémunération</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Salaire de base</span><span class="font-semibold">{{ number_format($payslip->salaire_base, 0, ',', ' ') }} FCFA</span></div>
                    @if($payslip->total_heures_sup > 0)
                        <div class="flex justify-between"><span>Heures supplémentaires</span><span class="font-semibold">{{ number_format($payslip->total_heures_sup, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    @if($payslip->total_primes > 0)
                        <div class="flex justify-between"><span>Primes</span><span class="font-semibold">{{ number_format($payslip->total_primes, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    @if($payslip->total_indemnites > 0)
                        <div class="flex justify-between"><span>Indemnités</span><span class="font-semibold">{{ number_format($payslip->total_indemnites, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    @if($payslip->avantages_nature > 0)
                        <div class="flex justify-between"><span>Avantages nature</span><span class="font-semibold">{{ number_format($payslip->avantages_nature, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    <div class="flex justify-between border-t pt-1 font-bold text-base"><span>Total brut</span><span>{{ number_format($payslip->total_brut, 0, ',', ' ') }} FCFA</span></div>
                </div>
            </div>

            {{-- CNPS --}}
            <div class="mb-4">
                <h3 class="text-xs font-bold uppercase text-gray-500 mb-2">Cotisations CNPS (salarié)</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Retraite (6.30%)</span><span>{{ number_format($payslip->cnps_retraite_salarie, 0, ',', ' ') }} FCFA</span></div>
                    <div class="flex justify-between"><span>CMU</span><span>{{ number_format($payslip->cnps_cmu_salarie, 0, ',', ' ') }} FCFA</span></div>
                    <div class="flex justify-between border-t pt-1 font-bold"><span>Total CNPS salarié</span><span>-{{ number_format($payslip->total_cnps_salarie, 0, ',', ' ') }} FCFA</span></div>
                </div>
            </div>

            {{-- ITS --}}
            <div class="mb-4">
                <h3 class="text-xs font-bold uppercase text-gray-500 mb-2">Impôt (ITS)</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Base imposable (80%)</span><span>{{ number_format($payslip->its_base, 0, ',', ' ') }} FCFA</span></div>
                    @if($payslip->its_brut > 0)
                        <div class="flex justify-between"><span>ITS brut</span><span>{{ number_format($payslip->its_brut, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    @if($payslip->its_credit > 0)
                        <div class="flex justify-between"><span>Crédit d'impôt</span><span>-{{ number_format($payslip->its_credit, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    <div class="flex justify-between border-t pt-1 font-bold"><span>ITS net</span><span>-{{ number_format($payslip->its_net, 0, ',', ' ') }} FCFA</span></div>
                </div>
            </div>

            {{-- Net --}}
            <div class="bg-gradient-to-r from-royal-50 to-royal-100 rounded-xl p-4 border border-royal-200">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-royal-900 text-lg">Net à payer</span>
                    <span class="font-black text-royal-900 text-2xl">{{ number_format($payslip->net_a_payer, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-3">Informations</h3>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-500">Matricule</span><div class="font-semibold">{{ $payslip->employee->matricule }}</div></div>
                    <div><span class="text-gray-500">Période</span><div class="font-semibold">{{ $payslip->moisLabel() }}</div></div>
                    <div><span class="text-gray-500">Validé par</span><div class="font-semibold">{{ $payslip->validePar?->name ?? '—' }}</div></div>
                    <div><span class="text-gray-500">Validé le</span><div class="font-semibold">{{ $payslip->valide_le?->format('d/m/Y H:i') ?? '—' }}</div></div>
                </div>
            </div>

            @if($payslip->notes)
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Notes</h3>
                    <p class="text-sm text-gray-600">{{ $payslip->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
