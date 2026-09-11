<x-layouts.app title="CMS — Éditer {{ $page->title }}">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('admin.cms.pages.index') }}" class="text-sm text-gray-400 hover:text-royal-600">&larr; Retour aux pages</a>
                <h1 class="text-2xl font-black text-gray-900 mt-1">{{ $page->title }}</h1>
                <p class="text-gray-500 text-sm">/{{ $page->slug }}</p>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Paramètres de la page</h2>
                <form method="POST" action="{{ route('admin.cms.pages.update', $page) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Titre</label>
                            <input type="text" name="title" value="{{ $page->title }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Template</label>
                            <input type="text" name="template" value="{{ $page->template }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Title (SEO)</label>
                            <input type="text" name="meta_title" value="{{ $page->meta_title }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ordre</label>
                            <input type="number" name="sort_order" value="{{ $page->sort_order }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Description (SEO)</label>
                            <textarea name="meta_description" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">{{ $page->meta_description }}</textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-royal-600">
                            <label class="text-sm text-gray-700">Page active</label>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 btn-primary text-white px-6 py-2 rounded-xl font-semibold text-sm">Sauvegarder</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Sections ({{ $page->sections->count() }})</h2>
                    <form method="POST" action="{{ route('admin.cms.pages.sections.store', $page) }}" class="flex gap-2">
                        @csrf
                        <select name="type" class="border border-gray-200 rounded-xl px-3 py-1.5 text-sm focus:outline-none focus:border-royal-500">
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
                        <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-xl text-sm font-semibold">+ Ajouter</button>
                    </form>
                </div>

                <div class="space-y-4">
                    @forelse($page->sections as $section)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs px-2 py-1 rounded-full bg-royal-100 text-royal-700 font-semibold uppercase">{{ $section->type }}</span>
                                    <span class="font-semibold text-gray-900">{{ $section->title ?? 'Sans titre' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs {{ $section->is_active ? 'text-green-600' : 'text-gray-400' }}">{{ $section->is_active ? 'Active' : 'Inactive' }}</span>
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
                                <button type="button" onclick="this.closest('form').querySelector('[name=content]').value=JSON.stringify(JSON.parse(this.closest('form').querySelector('[name=content]').value))" class="text-royal-600 hover:text-royal-800 text-sm font-semibold">Éditer le JSON</button>
                            </form>
                            <div class="flex gap-2 mt-3">
                                <form method="POST" action="{{ route('admin.cms.pages.sections.update', [$page, $section]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="content" value="{{ json_encode($section->content) }}">
                                    <input type="hidden" name="title" value="{{ $section->title }}">
                                    <input type="hidden" name="sort_order" value="{{ $section->sort_order }}">
                                    <input type="hidden" name="is_active" value="{{ $section->is_active ? 0 : 1 }}">
                                    <button type="submit" class="text-sm text-gray-500 hover:text-royal-600">{{ $section->is_active ? 'Désactiver' : 'Activer' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.cms.pages.sections.destroy', [$page, $section]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700" onclick="return confirm('Supprimer cette section ?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center py-8">Aucune section. Ajoutez-en une ci-dessus.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
