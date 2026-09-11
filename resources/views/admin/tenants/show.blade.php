<x-layouts.app :title="'Détail client'" :userName="$userName ?? 'Admin'">
    <div class="max-w-4xl space-y-6">
        <div>
            <a href="{{ route('admin.tenants.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-royal-600 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Retour aux clients
            </a>
            <div class="flex items-center gap-4 mt-1">
                <div class="w-12 h-12 bg-gradient-to-br from-royal-50 to-royal-100 rounded-2xl flex items-center justify-center">
                    <span class="text-royal-600 font-bold text-lg">{{ strtoupper(substr($tenant->name, 0, 2)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-gray-900">{{ $tenant->name }}</h1>
                    <p class="text-sm text-gray-500 font-mono">{{ $tenant->slug }}</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Abonnement --}}
            <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
                <h2 class="font-bold text-gray-900 mb-5">Abonnement</h2>
                @php
                    $statusVariants = [
                        'active' => 'success',
                        'trialing' => 'info',
                        'past_due' => 'warning',
                        'cancelled' => 'danger',
                        'expired' => 'default',
                        'none' => 'default',
                    ];
                    $statusLabels = [
                        'active' => 'Actif',
                        'trialing' => 'En essai',
                        'past_due' => 'Paiement en retard',
                        'cancelled' => 'Annulé',
                        'expired' => 'Expiré',
                        'none' => 'Aucun abonnement',
                    ];
                @endphp
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Statut</span>
                        <x-ui.badge :variant="$statusVariants[$tenant->subscription_status] ?? 'default'">
                            {{ $statusLabels[$tenant->subscription_status] ?? $tenant->subscription_status }}
                        </x-ui.badge>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Plan</span>
                        <span class="font-semibold text-sm">{{ $tenant->subscription?->plan?->name ?? $tenant->plan }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Expire le</span>
                        <span class="font-semibold text-sm">{{ $tenant->subscription_ends_at?->format('d/m/Y H:i') ?? $tenant->trial_ends_at?->format('d/m/Y H:i') ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-500">Dernier paiement</span>
                        <span class="font-semibold text-sm">{{ $tenant->last_payment_at?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <form method="POST" action="{{ route('admin.tenants.status', $tenant) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="subscription_status" value="active">
                        <button type="submit" class="w-full text-sm bg-emerald-50 text-emerald-700 border border-emerald-200/60 py-2.5 rounded-xl hover:bg-emerald-100 transition font-semibold">
                            Activer
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.tenants.status', $tenant) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="subscription_status" value="cancelled">
                        <button type="submit" class="w-full text-sm bg-rose-50 text-rose-700 border border-rose-200/60 py-2.5 rounded-xl hover:bg-rose-100 transition font-semibold">
                            Couper l'accès
                        </button>
                    </form>
                </div>
            </div>

            {{-- Paiement --}}
            <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
                <h2 class="font-bold text-gray-900 mb-5">Enregistrer un paiement</h2>
                <form method="POST" action="{{ route('admin.tenants.payment', $tenant) }}" class="space-y-4">
                    @csrf
                    <x-ui.input name="amount" label="Montant (FCFA)" type="number" placeholder="20000" :required="true" />
                    <x-ui.input name="extend_days" label="Prolonger de (jours)" type="number" value="30" :required="true" />
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="2" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400" placeholder="Virement, Mobile Money, etc."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-royal-600 to-royal-500 text-white py-3 rounded-xl font-semibold hover:from-royal-700 hover:to-royal-600 transition-all duration-200 shadow-md shadow-royal-500/20 hover:shadow-lg hover:shadow-royal-500/30">
                        Enregistrer et prolonger
                    </button>
                </form>
            </div>
        </div>

        {{-- Historique paiements --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Historique des paiements</h2>
            @if($tenant->payments->count())
                <table class="w-full">
                    <thead class="border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-3 tracking-wider">Date</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-3 tracking-wider">Montant</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-3 tracking-wider">Statut</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-3 tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tenant->payments as $payment)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3.5 text-sm text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3.5 text-sm font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} XOF</td>
                            <td class="py-3.5">
                                <x-ui.badge :variant="$payment->status === 'completed' ? 'success' : 'warning'">
                                    {{ $payment->status === 'completed' ? 'Complété' : ucfirst($payment->status) }}
                                </x-ui.badge>
                            </td>
                            <td class="py-3.5 text-sm text-gray-500">{{ $payment->notes ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
                    <p class="text-sm text-gray-400 font-medium">Aucun paiement enregistré</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
