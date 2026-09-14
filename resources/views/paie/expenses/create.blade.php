<x-layouts.app :title="'Nouvelle note de frais'">
    <div class="mb-6">
        <a href="{{ route('paie.expenses.index') }}" class="text-sm text-royal-600 hover:text-royal-800">&larr; Retour</a>
        <h1 class="text-xl font-bold text-gray-900 mt-2">Nouvelle note de frais</h1>
    </div>
    <form method="POST" action="{{ route('paie.expenses.store') }}" enctype="multipart/form-data" class="max-w-2xl">
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
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date *</label>
                    <input type="date" name="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Catégorie *</label>
                    <select name="categorie" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                        <option value="transport">Transport</option>
                        <option value="hebergement">Hébergement</option>
                        <option value="repas">Repas</option>
                        <option value="fournitures">Fournitures</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Montant (FCFA) *</label>
                    <input type="number" name="montant" min="1" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Justificatif (PDF/image, max 5 Mo)</label>
                <input type="file" name="justificatif" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('paie.expenses.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600">Annuler</a>
            <button type="submit" class="bg-gradient-to-r from-royal-500 to-royal-600 text-white px-6 py-2 rounded-xl text-sm font-semibold">Soumettre</button>
        </div>
    </form>
</x-layouts.app>
