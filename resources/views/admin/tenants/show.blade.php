<x-layouts.app :title="'Détail client'" :userName="$userName ?? 'Admin'">
    <div class="max-w-4xl space-y-6">
        <div>
            <a href="{{ route('admin.tenants.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour aux clients</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $tenant->name }}</h1>
            <p class="text-sm text-gray-500">{{ $tenant->slug }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Statut -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Abonnement</h2>
                @php
                    $statusColors = [
                        'active' => 'bg-green-100 text-green-700',
                        'trialing' => 'bg-blue-100 text-blue-700',
                        'past_due' => 'bg-yellow-100 text-yellow-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'expired' => 'bg-gray-100 text-gray-700',
                        'none' => 'bg-gray-100 text-gray-500',
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
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Statut</span>
                        <span class="font-medium px-2.5 py-0.5 rounded-full text-xs {{ $statusColors[$tenant->subscription_status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ $statusLabels[$tenant->subscription_status] ?? $tenant->subscription_status }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Plan</span>
                        <span class="font-medium">{{ $tenant->subscription?->plan?->name ?? $tenant->plan }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Expire le</span>
                        <span class="font-medium">{{ $tenant->subscription_ends_at?->format('d/m/Y H:i') ?? $tenant->trial_ends_at?->format('d/m/Y H:i') ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Dernier paiement</span>
                        <span class="font-medium">{{ $tenant->last_payment_at?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <form method="POST" action="{{ route('admin.tenants.status', $tenant) }}" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="subscription_status" value="active">
                        <button type="submit" class="flex-1 text-xs bg-green-50 text-green-700 border border-green-200 py-2 rounded-lg hover:bg-green-100 transition font-medium">Activer</button>
                    </form>
                    <form method="POST" action="{{ route('admin.tenants.status', $tenant) }}" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="subscription_status" value="cancelled">
                        <button type="submit" class="flex-1 text-xs bg-red-50 text-red-700 border border-red-200 py-2 rounded-lg hover:bg-red-100 transition font-medium">Couper l'accès</button>
                    </form>
                </div>
            </div>

            <!-- Ajouter paiement -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Enregistrer un paiement</h2>
                <form method="POST" action="{{ route('admin.tenants.payment', $tenant) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA) *</label>
                        <input type="number" name="amount" required min="1" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="20000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prolonger de (jours) *</label>
                        <input type="number" name="extend_days" required min="1" value="30" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="Virement, Mobile Money, etc."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-royal-600 text-white py-3 rounded-xl font-semibold hover:bg-royal-700 transition">
                        Enregistrer et prolonger
                    </button>
                </form>
            </div>
        </div>

        <!-- Historique paiements -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="font-bold text-gray-900 mb-4">Historique des paiements</h2>
            @if($tenant->payments->count())
                <table class="w-full">
                    <thead class="border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-2">Date</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-2">Montant</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-2">Statut</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase pb-2">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tenant->payments as $payment)
                        <tr>
                            <td class="py-3 text-sm text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-sm font-medium text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} XOF</td>
                            <td class="py-3">
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $payment->status === 'completed' ? 'Complété' : ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-500">{{ $payment->notes ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-400 text-center py-4">Aucun paiement enregistré.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
