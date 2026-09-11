<x-layouts.app :title="'Tableau de bord Paie'">
    {{-- Hero Header --}}
    <div class="bg-gradient-to-r from-royal-600 to-royal-800 rounded-2xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Tableau de bord — Paie</h1>
                <p class="text-royal-200 text-sm">{{ now()->translatedFormat('F Y') }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('paie.payslips.create') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl text-sm font-semibold transition">
                    + Générer un bulletin
                </a>
                <a href="{{ route('paie.simulateur') }}" class="bg-white text-royal-700 hover:bg-royal-50 px-4 py-2 rounded-xl text-sm font-bold transition shadow-lg">
                    Simulateur
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 p-5 glow-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $totalEmployees }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $activeEmployees }} actifs</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 glow-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $payslipsThisMonth }}</div>
            <div class="text-xs text-gray-500 mt-1">Bulletins ce mois</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 glow-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($totalNetThisMonth, 0, ',', ' ') }}</div>
            <div class="text-xs text-gray-500 mt-1">FCFA nets à payer</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 glow-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $pendingLeaves + $pendingExpenses }}</div>
            <div class="text-xs text-gray-500 mt-1">Éléments en attente</div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('paie.employees.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-royal-300 transition group">
            <div class="text-royal-600 font-semibold text-sm group-hover:text-royal-700">Employés</div>
            <div class="text-xs text-gray-500 mt-1">Gérer les fiches</div>
        </a>
        <a href="{{ route('paie.payslips.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-royal-300 transition group">
            <div class="text-royal-600 font-semibold text-sm group-hover:text-royal-700">Bulletins</div>
            <div class="text-xs text-gray-500 mt-1">Consulter l'historique</div>
        </a>
        <a href="{{ route('paie.leaves.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-royal-300 transition group">
            <div class="text-royal-600 font-semibold text-sm group-hover:text-royal-700">Congés</div>
            <div class="text-xs text-gray-500 mt-1">Gérer les demandes</div>
        </a>
        <a href="{{ route('paie.declarations.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 hover:border-royal-300 transition group">
            <div class="text-royal-600 font-semibold text-sm group-hover:text-royal-700">Déclarations</div>
            <div class="text-xs text-gray-500 mt-1">CNPS / ITS</div>
        </a>
    </div>

    {{-- Derniers bulletins --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Derniers bulletins</h2>
        </div>
        @if($recentPayslips->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">
                Aucun bulletin encore généré.
            </div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($recentPayslips as $payslip)
                    <a href="{{ route('paie.payslips.show', $payslip->id) }}" class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-royal-100 rounded-lg flex items-center justify-center">
                                <span class="text-royal-700 font-bold text-xs">{{ strtoupper(substr($payslip->employee->prenom ?? 'X', 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $payslip->employee->prenom ?? '' }} {{ $payslip->employee->nom ?? '' }}</div>
                                <div class="text-xs text-gray-500">{{ $payslip->moisLabel() }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900">{{ number_format($payslip->net_a_payer, 0, ',', ' ') }} FCFA</div>
                            <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full
                                {{ match($payslip->statut) {
                                    'brouillon' => 'bg-gray-100 text-gray-600',
                                    'valide' => 'bg-blue-100 text-blue-700',
                                    'paye' => 'bg-green-100 text-green-700',
                                    default => 'bg-gray-100 text-gray-600',
                                } }}">
                                {{ $payslip->status()->label() }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
