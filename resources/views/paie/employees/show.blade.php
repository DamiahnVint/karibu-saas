<x-layouts.app :title="$employee->prenom . ' ' . $employee->nom">
    <div class="mb-6">
        <a href="{{ route('paie.employees.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour à la liste</a>
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-royal-400 to-royal-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">{{ strtoupper(substr($employee->prenom, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</h1>
                    <p class="text-sm text-gray-500">{{ $employee->matricule }} — {{ $employee->poste ?? 'Poste non défini' }}</p>
                </div>
            </div>
            <span class="inline-block text-xs font-bold px-3 py-1 rounded-full
                {{ match($employee->statut) {
                    'actif' => 'bg-green-100 text-green-700',
                    'inactif' => 'bg-gray-100 text-gray-600',
                    'suspendu' => 'bg-amber-100 text-amber-700',
                    'radie' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-600',
                } }}">
                {{ \App\Enums\Paie\EmployeeStatut::tryFrom($employee->statut)?->label() }}
            </span>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'infos' }" class="space-y-6">
        <div class="flex gap-1 bg-gray-100 rounded-xl p-1">
            <button @click="tab = 'infos'" :class="tab === 'infos' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500'" class="flex-1 py-2 px-4 rounded-lg text-sm font-semibold transition">Informations</button>
            <button @click="tab = 'paie'" :class="tab === 'paie' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500'" class="flex-1 py-2 px-4 rounded-lg text-sm font-semibold transition">Paie</button>
            <button @click="tab = 'conges'" :class="tab === 'conges' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500'" class="flex-1 py-2 px-4 rounded-lg text-sm font-semibold transition">Congés</button>
        </div>

        {{-- Tab: Infos --}}
        <div x-show="tab === 'infos'" class="bg-white rounded-xl border border-gray-100 p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div><span class="text-gray-500">Email</span><div class="font-semibold">{{ $employee->email ?? '—' }}</div></div>
                <div><span class="text-gray-500">Téléphone</span><div class="font-semibold">{{ $employee->phone ?? '—' }}</div></div>
                <div><span class="text-gray-500">Date de naissance</span><div class="font-semibold">{{ $employee->date_naissance?->format('d/m/Y') ?? '—' }}</div></div>
                <div><span class="text-gray-500">Sexe</span><div class="font-semibold">{{ $employee->sexe === 'M' ? 'Masculin' : ($employee->sexe === 'F' ? 'Féminin' : '—') }}</div></div>
                <div><span class="text-gray-500">Situation familiale</span><div class="font-semibold">{{ \App\Enums\Paie\ContractType::tryFrom($employee->situation_familiale)?->label() ?? ucfirst($employee->situation_familiale) }}</div></div>
                <div><span class="text-gray-500">Enfants</span><div class="font-semibold">{{ $employee->nb_enfants }}</div></div>
                <div><span class="text-gray-500">Département</span><div class="font-semibold">{{ $employee->department?->name ?? '—' }}</div></div>
                <div><span class="text-gray-500">Date d'embauche</span><div class="font-semibold">{{ $employee->date_embauche->format('d/m/Y') }}</div></div>
                <div><span class="text-gray-500">Ancienneté</span><div class="font-semibold">{{ $employee->anciennete }} an(s)</div></div>
                <div><span class="text-gray-500">Type de contrat</span><div class="font-semibold">{{ \App\Enums\Paie\ContractType::tryFrom($employee->type_contrat)?->label() }}</div></div>
                <div><span class="text-gray-500">N° CNPS</span><div class="font-semibold">{{ $employee->cnps_numero ?? '—' }}</div></div>
                <div><span class="text-gray-500">Parts fiscales</span><div class="font-semibold">{{ $employee->parts_fiscales }}</div></div>
            </div>
        </div>

        {{-- Tab: Paie --}}
        <div x-show="tab === 'paie'" class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900">Bulletins de paie</h2>
                <a href="{{ route('paie.payslips.create') }}?employee_id={{ $employee->id }}" class="text-sm text-royal-600 hover:text-royal-800 font-semibold">+ Générer</a>
            </div>
            @if($employee->payslips->isEmpty())
                <div class="p-8 text-center text-gray-400 text-sm">Aucun bulletin.</div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($employee->payslips as $payslip)
                        <a href="{{ route('paie.payslips.show', $payslip->id) }}" class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $payslip->moisLabel() }}</div>
                                <div class="text-xs text-gray-500">Brut: {{ number_format($payslip->total_brut, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-gray-900">{{ number_format($payslip->net_a_payer, 0, ',', ' ') }} FCFA</div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-{{ $payslip->status()->color() }}-100 text-{{ $payslip->status()->color() }}-700">{{ $payslip->status()->label() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tab: Congés --}}
        <div x-show="tab === 'conges'" class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-900">Congés</h2>
            </div>
            @if($employee->leaves->isEmpty())
                <div class="p-8 text-center text-gray-400 text-sm">Aucun congé enregistré.</div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($employee->leaves as $leave)
                        <div class="flex items-center justify-between px-6 py-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $leave->typeEnum()->label() }}</div>
                                <div class="text-xs text-gray-500">{{ $leave->date_debut->format('d/m/Y') }} — {{ $leave->date_fin->format('d/m/Y') }} ({{ $leave->nb_jours }}j)</div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-{{ $leave->statutEnum()->color() }}-100 text-{{ $leave->statutEnum()->color() }}-700">{{ $leave->statutEnum()->label() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
