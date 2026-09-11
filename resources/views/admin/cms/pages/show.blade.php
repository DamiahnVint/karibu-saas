<x-layouts.app title="CMS — Éditer {{ $page->title }}">
    <div class="max-w-5xl space-y-6">
        <div>
            <a href="{{ route('admin.cms.pages.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-royal-600 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Retour aux pages
            </a>
            <h1 class="text-2xl font-black text-gray-900">{{ $page->title }}</h1>
            <p class="text-gray-500 text-sm font-mono">/{{ $page->slug }}</p>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        {{-- Page settings --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Paramètres de la page</h2>
            <form method="POST" action="{{ route('admin.cms.pages.update', $page) }}">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-4">
                    <x-ui.input name="title" label="Titre" :value="$page->title" :required="true" />
                    <x-ui.input name="template" label="Template" :value="$page->template" />
                    <x-ui.input name="meta_title" label="Meta Title (SEO)" :value="$page->meta_title" />
                    <x-ui.input name="sort_order" label="Ordre" type="number" :value="$page->sort_order" />
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description (SEO)</label>
                        <textarea name="meta_description" rows="2" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400">{{ $page->meta_description }}</textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-royal-600 focus:ring-royal-500">
                        <label class="text-sm text-gray-700 font-medium">Page active</label>
                    </div>
                </div>
                <div class="mt-5">
                    <x-ui.button type="submit">Sauvegarder</x-ui.button>
                </div>
            </form>
        </div>

        {{-- Sections --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-gray-900">Sections ({{ $page->sections->count() }})</h2>
                <form method="POST" action="{{ route('admin.cms.pages.sections.store', $page) }}" class="flex gap-2">
                    @csrf
                    <select name="type" class="rounded-xl border-gray-200 bg-gray-50/50 text-sm focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 px-3 py-1.5">
                        <option value="hero">Hero</option>
                        <option value="features">Features</option>
                        <option value="pricing">Pricing</option>
                        <option value="testimonials">Témoignages</option>
                        <option value="cta">CTA</option>
                        <option value="text">Texte</option>
                        <option value="contact">Contact</option>
                        <option value="faq">FAQ</option>
                        <option value="gallery">Galerie</option>
                        <option value="html">HTML libre</option>
                    </select>
                    <x-ui.button type="submit" variant="success" size="sm">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Ajouter
                    </x-ui.button>
                </form>
            </div>

            <div class="space-y-3">
                @forelse($page->sections as $section)
                    <div class="border border-gray-100 rounded-xl p-4 hover:border-gray-200 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <x-ui.badge variant="primary">{{ strtoupper($section->type) }}</x-ui.badge>
                                <span class="font-semibold text-gray-900 text-sm">{{ $section->title ?? 'Sans titre' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-ui.badge :variant="$section->is_active ? 'success' : 'default'">
                                    {{ $section->is_active ? 'Active' : 'Inactive' }}
                                </x-ui.badge>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.cms.pages.sections.update', [$page, $section]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="content" value="{{ json_encode($section->content) }}">
                            <input type="hidden" name="title" value="{{ $section->title }}">
                            <input type="hidden" name="is_active" value="{{ $section->is_active ? 1 : 0 }}">
                            <input type="hidden" name="sort_order" value="{{ $section->sort_order }}">
                            <div class="text-sm text-gray-500 mb-3">
                                @if($section->type === 'hero')
                                    Titre: {{ $section->content['title'] ?? '-' }} | CTA: {{ $section->content['cta_text'] ?? '-' }}
                                @elseif($section->type === 'features')
                                    {{ count($section->content['items'] ?? []) }} feature(s)
                                @elseif($section->type === 'pricing')
                                    {{ count($section->content['plans'] ?? []) }} plan(s)
                                @elseif($section->type === 'text')
                                    {{ Str::limit(strip_tags($section->content['html_content'] ?? ''), 100) }}
                                @else
                                    {{ json_encode(array_keys($section->content)) }}
                                @endif
                            </div>
                            <button type="button" onclick="this.closest('form').querySelector('[name=content]').value=JSON.stringify(JSON.parse(this.closest('form').querySelector('[name=content]').value))" class="text-royal-600 hover:text-royal-800 text-sm font-semibold transition-colors">Éditer le JSON</button>
                        </form>
                        <div class="flex gap-3 mt-3 pt-3 border-t border-gray-50">
                            <form method="POST" action="{{ route('admin.cms.pages.sections.update', [$page, $section]) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="content" value="{{ json_encode($section->content) }}">
                                <input type="hidden" name="title" value="{{ $section->title }}">
                                <input type="hidden" name="sort_order" value="{{ $section->sort_order }}">
                                <input type="hidden" name="is_active" value="{{ $section->is_active ? 0 : 1 }}">
                                <button type="submit" class="text-sm text-gray-500 hover:text-royal-600 font-medium transition-colors">{{ $section->is_active ? 'Désactiver' : 'Activer' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.cms.pages.sections.destroy', [$page, $section]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors" onclick="return confirm('Supprimer cette section ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/></svg>
                        <p class="text-gray-400 text-sm font-medium">Aucune section</p>
                        <p class="text-gray-300 text-xs mt-1">Ajoutez-en une ci-dessus</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
