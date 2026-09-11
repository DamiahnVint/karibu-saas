<x-layouts.app :title="'Modifier le plan'" :userName="$userName ?? 'Admin'">
    <div class="max-w-2xl space-y-6">
        <div>
            <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-royal-600 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Retour aux plans
            </a>
            <h1 class="text-2xl font-black text-gray-900 mt-1">Modifier : {{ $plan->name }}</h1>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="bg-white rounded-2xl border border-gray-100/80 p-6 space-y-5">
            @csrf
            @method('PUT')

            <x-ui.input name="name" label="Nom du plan" :value="old('name', $plan->name)" :required="true" />

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-ui.input name="price" label="Prix (FCFA)" type="number" :value="old('price', $plan->price)" :required="true" />
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cycle *</label>
                    <select name="billing_cycle" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm">
                        <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) === 'monthly' ? 'selected' : '' }}>Mensuel</option>
                        <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) === 'yearly' ? 'selected' : '' }}>Annuel</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-ui.input name="max_employees" label="Employés max" type="number" :value="old('max_employees', $plan->max_employees)" :required="true" />
                <x-ui.input name="trial_days" label="Jours d'essai" type="number" :value="old('trial_days', $plan->trial_days)" :required="true" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Features (une par ligne)</label>
                <textarea name="features" rows="6" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400 font-mono text-xs">{{ old('features', implode("\n", $plan->features ?? [])) }}</textarea>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-royal-600 focus:ring-royal-500">
                    <label class="text-sm text-gray-700 font-medium">Actif sur le site</label>
                </div>
                <x-ui.input name="sort_order" label="Ordre d'affichage" type="number" :value="old('sort_order', $plan->sort_order)" />
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-royal-600 to-royal-500 text-white py-3 rounded-xl font-semibold hover:from-royal-700 hover:to-royal-600 transition-all duration-200 shadow-md shadow-royal-500/20 hover:shadow-lg hover:shadow-royal-500/30">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</x-layouts.app>
