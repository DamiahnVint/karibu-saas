<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with('subscription.plan');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('subscription_status', $status);
        }

        $tenants = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['subscription.plan', 'payments', 'users']);

        return view('admin.tenants.show', compact('tenant'));
    }

    public function updateStatus(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'subscription_status' => 'required|in:active,cancelled,past_due',
        ]);

        $tenant->update([
            'subscription_status' => $validated['subscription_status'],
            'subscription_ends_at' => $validated['subscription_status'] === 'cancelled'
                ? now()
                : $tenant->subscription_ends_at,
        ]);

        $subscription = $tenant->subscription;
        if ($subscription) {
            $subscription->update([
                'status' => $validated['subscription_status'],
                'cancelled_at' => $validated['subscription_status'] === 'cancelled'
                    ? now()
                    : $subscription->cancelled_at,
            ]);
        }

        return redirect()->route('admin.tenants.show', $tenant)
            ->with('success', 'Statut mis à jour avec succès.');
    }

    public function addPayment(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'extend_days' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $subscription = $tenant->subscription;

            if ($subscription) {
                $currentEnd = $subscription->ends_at ?? now();
                if ($currentEnd->isPast()) {
                    $currentEnd = now();
                }

                $newEnd = $currentEnd->addDays($validated['extend_days']);

                $subscription->update([
                    'status' => 'active',
                    'ends_at' => $newEnd,
                    'cancelled_at' => null,
                ]);

                $tenant->update([
                    'subscription_status' => 'active',
                    'subscription_ends_at' => $newEnd,
                    'last_payment_at' => now(),
                ]);
            }

            $tenant->payments()->create([
                'subscription_id' => $subscription?->id,
                'amount' => $validated['amount'],
                'currency' => 'XOF',
                'status' => 'completed',
                'provider' => 'manual',
                'notes' => $validated['notes'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('admin.tenants.show', $tenant)
                ->with('success', 'Paiement enregistré et abonnement prolongé.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['amount' => 'Erreur lors de l\'enregistrement du paiement.']);
        }
    }
}
