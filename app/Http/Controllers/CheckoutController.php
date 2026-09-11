<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $planSlug = $request->query('plan', 'essentiel');
        $plan = Plan::where('slug', $planSlug)->where('is_active', true)->firstOrFail();

        return view('checkout.index', compact('plan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'company_name' => 'required|string|max:255',
            'company_nif' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:500',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);

        DB::beginTransaction();

        try {
            $slug = Str::slug($validated['company_name']);
            $slug = $slug . '-' . Str::random(5);

            $tenant = Tenant::create([
                'name' => $validated['company_name'],
                'slug' => $slug,
                'plan' => $plan->is_trial ? 'free' : $plan->slug,
                'is_active' => true,
                'max_employees' => $plan->max_employees,
                'subscription_status' => $plan->is_trial ? 'trialing' : 'active',
                'trial_ends_at' => $plan->is_trial ? now()->addDays($plan->trial_days) : null,
                'subscription_ends_at' => $plan->is_trial ? null : now()->addMonth(),
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'tenant_owner',
                'tenant_id' => $tenant->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => $plan->is_trial ? 'trialing' : 'active',
                'starts_at' => now(),
                'trial_ends_at' => $plan->is_trial ? now()->addDays($plan->trial_days) : null,
                'ends_at' => $plan->is_trial ? null : now()->addMonth(),
            ]);

            DB::commit();

            auth()->login($user);

            return redirect()->route('dashboard')
                ->with('success', 'Bienvenue ! Votre compte a été créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'company_name' => 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.',
            ])->withInput();
        }
    }
}
