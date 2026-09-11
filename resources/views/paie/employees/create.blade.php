<x-layouts.app :title="'Nouvel employé'">
    <div class="mb-6">
        <a href="{{ route('paie.employees.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour à la liste</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Nouvel employé</h1>
    </div>

    <form method="POST" action="{{ route('paie.employees.store') }}" class="max-w-3xl">
        @csrf

        {{-- Infos personnelles --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Informations personnelles</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sexe</label>
                    <select name="sexe" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                        <option value="">—</option>
                        <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Situation familiale *</label>
                    <select name="situation_familiale" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="celibataire" {{ old('situation_familiale') === 'celibataire' ? 'selected' : '' }}>Célibataire</option>
                        <option value="marie" {{ old('situation_familiale') === 'marie' ? 'selected' : '' }}>Marié(e)</option>
                        <option value="divorce" {{ old('situation_familiale') === 'divorce' ? 'selected' : '' }}>Divorcé(e)</option>
                        <option value="veuf" {{ old('situation_familiale') === 'veuf' ? 'selected' : '' }}>Veuf/Veuve</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre d'enfants</label>
                    <input type="number" name="nb_enfants" value="{{ old('nb_enfants', 0) }}" min="0" max="20" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
            </div>
        </div>

        {{-- Infos professionnelles --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Informations professionnelles</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Poste</label>
                    <input type="text" name="poste" value="{{ old('poste') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Département</label>
                    <select name="department_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                        <option value="">— Aucun —</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date d'embauche *</label>
                    <input type="date" name="date_embauche" value="{{ old('date_embauche', now()->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Type de contrat *</label>
                    <select name="type_contrat" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="cdi" {{ old('type_contrat') === 'cdi' ? 'selected' : '' }}>CDI</option>
                        <option value="cdd" {{ old('type_contrat') === 'cdd' ? 'selected' : '' }}>CDD</option>
                        <option value="saisonnier" {{ old('type_contrat') === 'saisonnier' ? 'selected' : '' }}>Saisonnier</option>
                        <option value="stage" {{ old('type_contrat') === 'stage' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date fin de contrat</label>
                    <input type="date" name="duree_contrat" value="{{ old('duree_contrat') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Statut *</label>
                    <select name="statut" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="actif" {{ old('statut', 'actif') === 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                        <option value="suspendu" {{ old('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                        <option value="radie" {{ old('statut') === 'radie' ? 'selected' : '' }}>Radié</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Salaire & Paiement --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <h2 class="font-bold text-gray-900 mb-4">Salaire & Paiement</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Salaire de base (FCFA) *</label>
                    <input type="number" name="salaire_base" value="{{ old('salaire_base') }}" min="1" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mode de paiement *</label>
                    <select name="mode_paiement" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="virement" {{ old('mode_paiement') === 'virement' ? 'selected' : '' }}>Virement</option>
                        <option value="cheque" {{ old('mode_paiement') === 'cheque' ? 'selected' : '' }}>Chèque</option>
                        <option value="especes" {{ old('mode_paiement') === 'especes' ? 'selected' : '' }}>Espèces</option>
                        <option value="mobile_money" {{ old('mode_paiement') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Banque</label>
                    <input type="text" name="banque" value="{{ old('banque') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">RIB</label>
                    <input type="text" name="rib" value="{{ old('rib') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">N° CNPS</label>
                    <input type="text" name="cnps_numero" value="{{ old('cnps_numero') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('paie.employees.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">Annuler</a>
            <button type="submit" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-6 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition">
                Créer l'employé
            </button>
        </div>
    </form>
</x-layouts.app>
