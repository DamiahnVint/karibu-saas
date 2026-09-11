<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class AdminPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('sort_order')->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'max_employees' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'is_active' => 'required|boolean',
            'sort_order' => 'required|integer|min:0',
            'trial_days' => 'required|integer|min:1',
        ]);

        $features = null;
        if (!empty($validated['features'])) {
            $features = array_map('trim', explode("\n", $validated['features']));
            $features = array_filter($features);
            $features = array_values($features);
        }

        $plan->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'max_employees' => $validated['max_employees'],
            'features' => $features,
            'is_active' => (bool) $validated['is_active'],
            'sort_order' => $validated['sort_order'],
            'trial_days' => $validated['trial_days'],
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan mis à jour avec succès.');
    }

    public function toggle(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        $status = $plan->is_active ? 'activé' : 'désactivé';

        return redirect()->route('admin.plans.index')
            ->with('success', "Plan {$status} avec succès.");
    }
}
