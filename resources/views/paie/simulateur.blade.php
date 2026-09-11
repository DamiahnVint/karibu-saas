<x-layouts.app :title="'Simulateur de paie'">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Simulateur de paie</h1>
        <p class="text-sm text-gray-500">Estimez le net à payer sans enregistrer</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="simulateur()" x-init="init()">
        {{-- Formulaire --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Paramètres</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Salaire de base (FCFA) *</label>
                        <input type="number" x-model.number="form.salaire_base" min="1" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Situation familiale</label>
                        <select x-model="form.situation_familiale" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                            <option value="celibataire">Célibataire</option>
                            <option value="marie">Marié(e)</option>
                            <option value="divorce">Divorcé(e)</option>
                            <option value="veuf">Veuf/Veuve</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre d'enfants</label>
                        <input type="number" x-model.number="form.nb_enfants" min="0" max="20" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Heures supplémentaires</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Heures sup. jour (150%)</label>
                        <input type="number" x-model.number="form.heures_sup_jour" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Heures sup. nuit (200%)</label>
                        <input type="number" x-model.number="form.heures_sup_nuit" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Primes & Indemnités</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Prime ancienneté</label>
                        <input type="number" x-model.number="form.prime_anciennete" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Prime rendement</label>
                        <input type="number" x-model.number="form.prime_rendement" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Indemnité transport</label>
                        <input type="number" x-model.number="form.indemnite_transport" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Indemnité logement</label>
                        <input type="number" x-model.number="form.indemnite_logement" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                </div>
                <button @click="calculer()" :disabled="loading" class="mt-4 w-full bg-gradient-to-r from-royal-500 to-royal-600 text-white py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition disabled:opacity-50">
                    <span x-show="!loading">Calculer</span>
                    <span x-show="loading">Calcul en cours...</span>
                </button>
            </div>
        </div>

        {{-- Résultat --}}
        <div>
            <div class="bg-white rounded-xl border border-gray-100 p-6 sticky top-20">
                <h2 class="font-bold text-gray-900 mb-4">Résultat</h2>
                <template x-if="result">
                    <div class="space-y-4">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">Salaire de base</span><span class="font-semibold" x-text="format(result.salaire_base) + ' FCFA'"></span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Heures sup.</span><span class="font-semibold" x-text="format(result.total_heures_sup) + ' FCFA'"></span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Primes</span><span class="font-semibold" x-text="format(result.total_primes) + ' FCFA'"></span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Indemnités</span><span class="font-semibold" x-text="format(result.total_indemnites) + ' FCFA'"></span></div>
                            <div class="flex justify-between border-t pt-2 font-bold"><span>Total brut</span><span x-text="format(result.total_brut) + ' FCFA'"></span></div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <h3 class="text-xs font-bold uppercase text-gray-500">Cotisations CNPS</h3>
                            <div class="flex justify-between"><span>Retraite salarié (6.30%)</span><span class="text-red-600" x-text="'-' + format(result.cnps_retraite_salarie)"></span></div>
                            <div class="flex justify-between"><span>CMU salarié</span><span class="text-red-600" x-text="'-' + format(result.cnps_cmu_salarie)"></span></div>
                            <div class="flex justify-between border-t pt-1 font-bold"><span>Total CNPS salarié</span><span class="text-red-600" x-text="'-' + format(result.total_cnps_salarie)"></span></div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <h3 class="text-xs font-bold uppercase text-gray-500">Impôt (ITS)</h3>
                            <div class="flex justify-between"><span>Base imposable (80%)</span><span x-text="format(result.its_base)"></span></div>
                            <div class="flex justify-between"><span>ITS brut</span><span x-text="format(result.its_brut)"></span></div>
                            <div class="flex justify-between"><span>Crédit impôt</span><span x-text="'-' + format(result.its_credit)"></span></div>
                            <div class="flex justify-between border-t pt-1 font-bold"><span>ITS net</span><span class="text-red-600" x-text="'-' + format(result.its_net)"></span></div>
                        </div>

                        <div class="bg-gradient-to-r from-royal-50 to-royal-100 rounded-xl p-4 border border-royal-200 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-royal-900 text-lg">Net à payer</span>
                                <span class="font-black text-royal-900 text-2xl" x-text="format(result.net_a_payer) + ' FCFA'"></span>
                            </div>
                        </div>

                        <div class="text-xs text-gray-400 mt-2">
                            <p>CNPS employeur: <span x-text="format(result.total_cnps_employeur)"></span> FCFA (non déduit du salaire)</p>
                            <p>Parts fiscales: <span x-text="result.parts_fiscales"></span></p>
                        </div>
                    </div>
                </template>
                <template x-if="!result">
                    <div class="text-center text-gray-400 text-sm py-8">
                        Remplissez le formulaire et cliquez sur "Calculer"
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function simulateur() {
            return {
                form: {
                    salaire_base: 500000,
                    situation_familiale: 'celibataire',
                    nb_enfants: 0,
                    heures_sup_jour: 0,
                    heures_sup_nuit: 0,
                    prime_anciennete: 0,
                    prime_rendement: 0,
                    prime_risque: 0,
                    prime_13eme: 0,
                    indemnite_transport: 0,
                    indemnite_logement: 0,
                    indemnite_responsabilite: 0,
                    avantages_nature: 0,
                },
                result: null,
                loading: false,

                init() {
                    this.calculer();
                },

                async calculer() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("paie.simulateur.run") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.form),
                        });
                        this.result = await response.json();
                    } catch (e) {
                        console.error(e);
                    }
                    this.loading = false;
                },

                format(value) {
                    return new Intl.NumberFormat('fr-FR').format(value || 0);
                }
            }
        }
    </script>
</x-layouts.app>
