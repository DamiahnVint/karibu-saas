<x-layouts.app title="CMS Dashboard">
    <div class="space-y-8">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">CMS Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez le contenu de votre site web</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-royal-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-royal-50 rounded-xl flex items-center justify-center group-hover:bg-royal-100 transition-colors">
                        <svg class="w-5 h-5 text-royal-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['pages'] }}</div>
                <div class="text-sm text-gray-500">Pages</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-emerald-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['pages_active'] }}</div>
                <div class="text-sm text-gray-500">Actives</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-sky-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center group-hover:bg-sky-100 transition-colors">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['sections'] }}</div>
                <div class="text-sm text-gray-500">Sections</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-purple-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['media'] }}</div>
                <div class="text-sm text-gray-500">Médias</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md hover:border-amber-200/50 transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['forms_unread'] }}</div>
                <div class="text-sm text-gray-500">Formulaires non lus</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:shadow-md transition-all duration-200 group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-black text-gray-900">{{ $stats['settings'] }}</div>
                <div class="text-sm text-gray-500">Paramètres</div>
            </div>
        </div>

        {{-- Recent activity --}}
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Dernières pages modifiées</h2>
                <div class="space-y-2">
                    @forelse($recentPages as $page)
                        <a href="{{ route('admin.cms.pages.show', $page) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-royal-50 rounded-lg flex items-center justify-center group-hover:bg-royal-100 transition-colors">
                                    <svg class="w-4 h-4 text-royal-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">{{ $page->title }}</div>
                                    <div class="text-xs text-gray-400 font-mono">/{{ $page->slug }}</div>
                                </div>
                            </div>
                            <x-ui.badge :variant="$page->is_active ? 'success' : 'default'">
                                {{ $page->is_active ? 'Active' : 'Inactive' }}
                            </x-ui.badge>
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-gray-400 text-sm">Aucune page.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Dernières soumissions</h2>
                <div class="space-y-2">
                    @forelse($recentSubmissions as $sub)
                        <a href="{{ route('admin.cms.forms.show', $sub) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">{{ $sub->form_type === 'contact' ? 'Contact' : 'Démo' }}</div>
                                    <div class="text-xs text-gray-400">{{ $sub->data['name'] ?? $sub->data['email'] ?? 'N/A' }}</div>
                                </div>
                            </div>
                            @if(!$sub->is_read)
                                <span class="w-2.5 h-2.5 bg-amber-400 rounded-full ring-4 ring-amber-50"></span>
                            @endif
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <p class="text-gray-400 text-sm">Aucune soumission.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.cms.pages.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-royal-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-royal-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-royal-100 transition-colors">
                    <svg class="w-5 h-5 text-royal-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Pages</div>
            </a>
            <a href="{{ route('admin.cms.settings.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-amber-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-100 transition-colors">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Paramètres</div>
            </a>
            <a href="{{ route('admin.cms.navigation.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-sky-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-sky-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-sky-100 transition-colors">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Navigation</div>
            </a>
            <a href="{{ route('admin.cms.media.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-purple-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-100 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Médias</div>
            </a>
            <a href="{{ route('admin.cms.forms.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-emerald-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Formulaires</div>
            </a>
            <a href="{{ route('admin.plans.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100/80 hover:border-rose-200/50 hover:shadow-md transition-all duration-200 text-center group">
                <div class="w-11 h-11 bg-rose-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-rose-100 transition-colors">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-sm font-semibold text-gray-700">Plans</div>
            </a>
        </div>
    </div>
</x-layouts.app>
