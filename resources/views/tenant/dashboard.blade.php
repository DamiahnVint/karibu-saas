<x-layouts.app :title="'Dashboard'" :userName="$userName">
    <div class="space-y-8">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-royal-600 via-royal-500 to-royal-700 rounded-2xl p-8 text-white">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/2 -translate-x-1/4 blur-2xl"></div>
            </div>
            <div class="relative">
                <h1 class="text-2xl font-black">Bonjour, {{ explode(' ', $userName)[0] }} 👋</h1>
                <p class="mt-1 text-sm text-white/70">
                    @if($isSuperAdmin)
                        Panneau de contrôle — Administration Karibu Technologies
                    @else
                        {{ $tenantName }} — {{ \App\Enums\Role::tryFrom($userRole)?->label() ?? $userRole }}
                    @endif
                </p>
            </div>
        </div>

        {{-- Stats super_admin --}}
        @if($isSuperAdmin)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-royal-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-royal-50 rounded-xl flex items-center justify-center group-hover:bg-royal-100 transition-colors">
                        <svg class="w-5 h-5 text-royal-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['tenants_active'] }}</div>
                <div class="text-sm text-gray-500 mt-0.5">Tenants actifs</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $stats['tenants_total'] }} total</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-emerald-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['plans_total'] }}</div>
                <div class="text-sm text-gray-500 mt-0.5">Plans créés</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-royal-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-royal-50 rounded-xl flex items-center justify-center group-hover:bg-royal-100 transition-colors">
                        <svg class="w-5 h-5 text-royal-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['pages_active'] }}</div>
                <div class="text-sm text-gray-500 mt-0.5">Pages CMS</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $stats['pages_total'] }} total</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-amber-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['forms_unread'] }}</div>
                <div class="text-sm text-gray-500 mt-0.5">Formulaires non lus</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-300">0</div>
                <div class="text-sm text-gray-500 mt-0.5">Employés</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-300">0 FCFA</div>
                <div class="text-sm text-gray-500 mt-0.5">Masse salariale</div>
            </div>
        </div>
        @endif

        {{-- Accès rapides --}}
        <div>
            <h2 class="text-lg font-bold text-gray-900 mb-4">Accès rapides</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if($isSuperAdmin)
                <a href="{{ route('admin.cms.dashboard') }}" class="group bg-white rounded-2xl p-6 border border-gray-100/80 hover:border-royal-300/50 hover:shadow-lg hover:shadow-royal-500/5 transition-all duration-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-royal-50 to-royal-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-royal-500 group-hover:to-royal-600 transition-all duration-200 shadow-sm group-hover:shadow-md group-hover:shadow-royal-500/20">
                        <svg class="w-6 h-6 text-royal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">CMS</h3>
                    <p class="text-sm text-gray-500">Gérez les pages, sections, navigation et médias du site</p>
                </a>

                <a href="{{ route('admin.cms.pages.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100/80 hover:border-sky-300/50 hover:shadow-lg hover:shadow-sky-500/5 transition-all duration-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-sky-50 to-sky-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-sky-500 group-hover:to-sky-600 transition-all duration-200 shadow-sm group-hover:shadow-md group-hover:shadow-sky-500/20">
                        <svg class="w-6 h-6 text-sky-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Pages</h3>
                    <p class="text-sm text-gray-500">Éditez le contenu des pages et leurs sections</p>
                </a>

                <a href="{{ route('admin.plans.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100/80 hover:border-emerald-300/50 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-emerald-500 group-hover:to-emerald-600 transition-all duration-200 shadow-sm group-hover:shadow-md group-hover:shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Plans & Tarifs</h3>
                    <p class="text-sm text-gray-500">Gérez les offres d'abonnement et leur prix</p>
                </a>

                <a href="{{ route('admin.tenants.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100/80 hover:border-purple-300/50 hover:shadow-lg hover:shadow-purple-500/5 transition-all duration-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-purple-500 group-hover:to-purple-600 transition-all duration-200 shadow-sm group-hover:shadow-md group-hover:shadow-purple-500/20">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Tenants</h3>
                    <p class="text-sm text-gray-500">Gérez les abonnements et accès clients</p>
                </a>

                <a href="{{ route('admin.cms.settings.index') }}" class="group bg-white rounded-2xl p-6 border border-gray-100/80 hover:border-amber-300/50 hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-amber-500 group-hover:to-amber-600 transition-all duration-200 shadow-sm group-hover:shadow-md group-hover:shadow-amber-500/20">
                        <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Paramètres</h3>
                    <p class="text-sm text-gray-500">Configurez les paramètres globaux du site</p>
                </a>

                <div class="bg-gray-50/50 rounded-2xl p-6 border border-dashed border-gray-200 opacity-60">
                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-500 mb-1">Module Paie</h3>
                    <p class="text-sm text-gray-400">Bientôt disponible — gestion des employés, bulletins, CNPS, ITS</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Guide de démarrage --}}
        @if($isSuperAdmin)
        <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Démarrage rapide</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex gap-4 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-royal-50 to-royal-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:from-royal-500 group-hover:to-royal-600 transition-all duration-200 shadow-sm">
                        <span class="text-royal-600 font-bold group-hover:text-white transition-colors">1</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Configurez le site</div>
                        <div class="text-sm text-gray-500 mt-0.5">Paramètres, navigation, contenu des pages</div>
                    </div>
                </div>
                <div class="flex gap-4 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-royal-50 to-royal-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:from-royal-500 group-hover:to-royal-600 transition-all duration-200 shadow-sm">
                        <span class="text-royal-600 font-bold group-hover:text-white transition-colors">2</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Définissez les plans</div>
                        <div class="text-sm text-gray-500 mt-0.5">Créez les offres et tarifs d'abonnement</div>
                    </div>
                </div>
                <div class="flex gap-4 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-royal-50 to-royal-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:from-royal-500 group-hover:to-royal-600 transition-all duration-200 shadow-sm">
                        <span class="text-royal-600 font-bold group-hover:text-white transition-colors">3</span>
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
