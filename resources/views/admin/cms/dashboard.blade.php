<x-layouts.app title="CMS Dashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-900">CMS Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez le contenu de votre site web</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-royal-600">{{ $stats['pages'] }}</div>
                <div class="text-sm text-gray-500">Pages</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-green-600">{{ $stats['pages_active'] }}</div>
                <div class="text-sm text-gray-500">Actives</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-royal-600">{{ $stats['sections'] }}</div>
                <div class="text-sm text-gray-500">Sections</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-royal-600">{{ $stats['media'] }}</div>
                <div class="text-sm text-gray-500">Médias</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-orange-600">{{ $stats['forms_unread'] }}</div>
                <div class="text-sm text-gray-500">Formulaires non lus</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100">
                <div class="text-2xl font-black text-royal-600">{{ $stats['settings'] }}</div>
                <div class="text-sm text-gray-500">Paramètres</div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Dernières pages modifiées</h2>
                <div class="space-y-3">
                    @forelse($recentPages as $page)
                        <a href="{{ route('admin.cms.pages.show', $page) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $title = $page->title }}</div>
                                <div class="text-sm text-gray-400">/{{ $page->slug }}</div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $page->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $page->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm">Aucune page.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Dernières soumissions</h2>
                <div class="space-y-3">
                    @forelse($recentSubmissions as $sub)
                        <a href="{{ route('admin.cms.forms.show', $sub) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $sub->form_type === 'contact' ? 'Contact' : 'Démo' }}</div>
                                <div class="text-sm text-gray-400">{{ $sub->data['name'] ?? $sub->data['email'] ?? 'N/A' }}</div>
                            </div>
                            @if(!$sub->is_read)
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                            @endif
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm">Aucune soumission.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.cms.pages.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">📄</div>
                <div class="text-sm font-semibold text-gray-700">Pages</div>
            </a>
            <a href="{{ route('admin.cms.settings.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">⚙️</div>
                <div class="text-sm font-semibold text-gray-700">Paramètres</div>
            </a>
            <a href="{{ route('admin.cms.navigation.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">🧭</div>
                <div class="text-sm font-semibold text-gray-700">Navigation</div>
            </a>
            <a href="{{ route('admin.cms.media.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">🖼️</div>
                <div class="text-sm font-semibold text-gray-700">Médias</div>
            </a>
            <a href="{{ route('admin.cms.forms.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">📝</div>
                <div class="text-sm font-semibold text-gray-700">Formulaires</div>
            </a>
            <a href="{{ route('admin.plans.index') }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:border-royal-300 transition text-center">
                <div class="text-2xl mb-1">💰</div>
                <div class="text-sm font-semibold text-gray-700">Plans</div>
            </a>
        </div>
    </div>
</x-layouts.app>
