<x-layouts.app :title="'Nouvelle demande de congé'">
    <div class="mb-6">
        <a href="{{ route('paie.leaves.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Nouvelle demande de congé</h1>
    </div>
    <form method="POST" action="{{ route('paie.leaves.store') }}" class="max-w-2xl">
        @csrf
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Employé *</label>
                <select name="employee_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                    <option value="">Sélectionner</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->prenom }} {{ $emp->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Type de congé *</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                    <option value="paye">Congé payé</option>
                    <option value="maladie">Maladie</option>
                    <option value="maternite">Maternité</option>
                    <option value="paternite">Paternité</option>
                    <option value="sans_solde">Sans solde</option>
                    <option value="deces">Décès</option>
                    <option value="mariage">Mariage</option>
                    <option value="naissance">Naissance</option>
                </select>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date début *</label>
                    <input type="date" name="date_debut" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date fin *</label>
                    <input type="date" name="date_fin" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre de jours *</label>
                    <input type="number" name="nb_jours" min="1" max="365" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Motif</label>
                <textarea name="motif" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm"></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('paie.leaves.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600">Annuler</a>
            <button type="submit" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-6 py-2 rounded-xl text-sm font-semibold">Soumettre</button>
        </div>
    </form>
</x-layouts.app>
