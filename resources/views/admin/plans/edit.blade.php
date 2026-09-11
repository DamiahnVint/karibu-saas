<x-layouts.app :title="'Modifier le plan'" :userName="$userName ?? 'Admin'">
    <div class="max-w-2xl space-y-6">
        <div>
            <a href="{{ route('admin.plans.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour aux plans</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">Modifier : {{ $plan->name }}</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du plan *</label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="2" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA) *</label>
                    <input type="number" name="price" value="{{ old('price', $plan->price) }}" required min="0" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cycle *</label>
                    <select name="billing_cycle" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                        <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) === 'monthly' ? 'selected' : '' }}>Mensuel</option>
                        <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) === 'yearly' ? 'selected' : '' }}>Annuel</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Employés max *</label>
                    <input type="number" name="max_employees" value="{{ old('max_employees', $plan->max_employees) }}" required min="1" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jours d'essai *</label>
                    <input type="number" name="trial_days" value="{{ old('trial_days', $plan->trial_days) }}" required min="1" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Features (une par ligne)</label>
                <textarea name="features" rows="6" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500 font-mono text-xs">{{ old('features', implode("\n", $plan->features ?? [])) }}</textarea>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-royal-600 focus:ring-royal-500">
                    <label class="text-sm text-gray-700">Actif sur le site</label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" min="0" class="w-20 rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-royal-600 text-white py-3 rounded-xl font-semibold hover:bg-royal-700 transition">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</x-layouts.app>
