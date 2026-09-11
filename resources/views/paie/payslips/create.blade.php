<x-layouts.app :title="'Générer un bulletin'">
    <div class="mb-6">
        <a href="{{ route('paie.payslips.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Générer un bulletin de paie</h1>
    </div>

    <form method="POST" action="{{ route('paie.payslips.store') }}" class="max-w-3xl" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Période & Employé</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Employé *</label>
                    <select name="employee_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mois *</label>
                    <select name="mois" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (int) now()->month === $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Année *</label>
                    <select name="annee" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        @for($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Heures supplémentaires</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Heures sup. jour (150%)</label>
                    <input type="number" name="heures_sup_jour" value="{{ old('heures_sup_jour', 0) }}" min="0" max="240" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Heures sup. nuit (200%)</label>
                    <input type="number" name="heures_sup_nuit" value="{{ old('heures_sup_nuit', 0) }}" min="0" max="120" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Primes</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Prime d'ancienneté</label>
                    <input type="number" name="prime_anciennete" value="{{ old('prime_anciennete', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Prime de rendement</label>
                    <input type="number" name="prime_rendement" value="{{ old('prime_rendement', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Prime de risque</label>
                    <input type="number" name="prime_risque" value="{{ old('prime_risque', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">13ème mois (pro-rata)</label>
                    <input type="number" name="prime_13eme" value="{{ old('prime_13eme', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Indemnités</h2>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Transport</label>
                    <input type="number" name="indemnite_transport" value="{{ old('indemnite_transport', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Logement</label>
                    <input type="number" name="indemnite_logement" value="{{ old('indemnite_logement', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Responsabilité</label>
                    <input type="number" name="indemnite_responsabilite" value="{{ old('indemnite_responsabilite', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Avantages nature</label>
                <input type="number" name="avantages_nature" value="{{ old('avantages_nature', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
            <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('paie.payslips.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">Annuler</a>
            <button type="submit" :disabled="submitting" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-6 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition disabled:opacity-50">
                <span x-show="!submitting">Générer le bulletin</span>
                <span x-show="submitting">Calcul en cours...</span>
            </button>
        </div>
    </form>
</x-layouts.app>
