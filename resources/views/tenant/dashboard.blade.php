<x-layouts.app :title="'Dashboard'" :userName="$userName">
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-black text-gray-900">Bonjour, {{ explode(' ', $userName)[0] }}</h1>
            <p class="mt-1 text-sm text-gray-500">
                @if($isSuperAdmin)
                    Panneau de contrôle — Administration Karibu Technologies
                @else
                    {{ $tenantName }} — {{ \App\Enums\Role::tryFrom($userRole)?->label() ?? $userRole }}
                @endif
            </p>
        </div>

        {{-- Stats super_admin --}}
        @if($isSuperAdmin)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-royal-600">{{ $stats['tenants_active'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Tenants actifs</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $stats['tenants_total'] }} total</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-green-600">{{ $stats['plans_total'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Plans créés</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-royal-600">{{ $stats['pages_active'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Pages CMS</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $stats['pages_total'] }} total</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-amber-600">{{ $stats['forms_unread'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Formulaires non lus</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-gray-400">0</div>
                <div class="text-sm text-gray-500 mt-1">Employés</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition">
                <div class="text-2xl font-black text-gray-400">0 FCFA</div>
                <div class="text-sm text-gray-500 mt-1">Masse salariale</div>
            </div>
        </div>
        @endif

        {{-- Accès rapides --}}
        <div>
            <h2 class="text-lg font-bold text-gray-900 mb-4">Accès rapides</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if($isSuperAdmin)
                <a href="{{ route('admin.cms.dashboard') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-royal-300 hover:shadow-lg transition-all duration-200">
                    <div class="w-12 h-12 bg-royal-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-royal-600 transition-colors">
                        <svg class="w-6 h-6 text-royal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">CMS</h3>
                    <p class="text-sm text-gray-500">Gérez les pages, sections, navigation et médias du site</p>
                </a>

                <a href="{{ route('admin.cms.pages.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-royal-300 hover:shadow-lg transition-all duration-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Pages</h3>
                    <p class="text-sm text-gray-500">Éditez le contenu des pages et leurs sections</p>
                </a>

                <a href="{{ route('admin.plans.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-royal-300 hover:shadow-lg transition-all duration-200">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-600 transition-colors">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Plans & Tarifs</h3>
                    <p class="text-sm text-gray-500">Gérez les offres d'abonnement et leur prix</p>
                </a>

                <a href="{{ route('admin.tenants.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-royal-300 hover:shadow-lg transition-all duration-200">
                    <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Tenants</h3>
                    <p class="text-sm text-gray-500">Gérez les abonnements et accès clients</p>
                </a>

                <a href="{{ route('admin.cms.settings.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-royal-300 hover:shadow-lg transition-all duration-200">
                    <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-amber-600 transition-colors">
                        <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Paramètres</h3>
                    <p class="text-sm text-gray-500">Configurez les paramètres globaux du site</p>
                </a>

                <div class="bg-gray-50 rounded-2xl p-6 border border-dashed border-gray-200 opacity-60">
                    <div class="w-12 h-12 bg-gray-200 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-500 mb-1">Module Paie</h3>
                    <p class="text-sm text-gray-400">Bientôt disponible — gestion des employés, bulletins, CNPS, ITS</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Guide de démarrage --}}
        @if($isSuperAdmin)
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-4">Démarrage rapide</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex gap-4">
                    <div class="w-10 h-10 bg-royal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-royal-700 font-bold">1</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Configurez le site</div>
                        <div class="text-sm text-gray-500 mt-0.5">Paramètres, navigation, contenu des pages</div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 bg-royal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-royal-700 font-bold">2</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Définissez les plans</div>
                        <div class="text-sm text-gray-500 mt-0.5">Créez les offres et tarifs d'abonnement</div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 bg-royal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-royal-700 font-bold">3</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Module Paie</div>
                        <div class="text-sm text-gray-500 mt-0.5">Bientôt — employés, bulletins, déclarations</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
