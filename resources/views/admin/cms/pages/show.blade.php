<x-layouts.app title="CMS — Éditer {{ $page->title }}">
    <div class="max-w-5xl space-y-6" x-data="jsonEditor()">
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
                        <form id="section-form-{{ $section->id }}" method="POST" action="{{ route('admin.cms.pages.sections.update', [$page, $section]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="content" id="section-content-{{ $section->id }}" value="{{ json_encode($section->content) }}">
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
                            <button type="button"
                                @click="openEditor({{ $section->id }}, `{{ json_encode($section->content) }}`)"
                                class="text-royal-600 hover:text-royal-800 text-sm font-semibold transition-colors">
                                Éditer le JSON
                            </button>
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

        {{-- Modal éditeur JSON --}}
        <div x-show="editorOpen" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display:none;" @keydown.escape.window="closeEditor()">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col" x-show="editorOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" @click.outside="closeEditor()">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-900">Éditer le JSON</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Section #<span x-text="editorSectionId"></span> — Modifiez le contenu puis sauvegardez</p>
                    </div>
                    <button @click="closeEditor()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden p-6">
                    <textarea x-ref="jsonTextarea"
                        x-model="editorContent"
                        @input="validateJson()"
                        class="w-full h-full min-h-[400px] rounded-xl border-gray-200 bg-gray-900 text-green-400 font-mono text-sm p-4 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 resize-none"
                        spellcheck="false"
                        @keydown.tab.prevent="insertTab($event)"></textarea>
                </div>
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                    <div>
                        <span x-show="editorError" class="text-red-500 text-sm font-medium" x-text="editorError"></span>
                        <span x-show="!editorError" class="text-green-600 text-sm font-medium">JSON valide</span>
                    </div>
                    <div class="flex gap-3">
                        <button @click="formatJson()" type="button" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition">
                            Formater
                        </button>
                        <button @click="closeEditor()" type="button" class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                            Annuler
                        </button>
                        <button @click="saveEditor()" type="button" class="px-5 py-2 text-sm font-semibold text-white bg-royal-600 rounded-xl hover:bg-royal-700 transition shadow-sm">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function jsonEditor() {
            return {
                editorOpen: false,
                editorSectionId: null,
                editorContent: '',
                editorError: '',
                editorFormId: null,

                openEditor(sectionId, content) {
                    this.editorSectionId = sectionId;
                    this.editorFormId = 'section-form-' + sectionId;
                    try {
                        const parsed = JSON.parse(content);
                        this.editorContent = JSON.stringify(parsed, null, 2);
                    } catch (e) {
                        this.editorContent = content;
                    }
                    this.editorError = '';
                    this.editorOpen = true;
                    this.$nextTick(() => {
                        if (this.$refs.jsonTextarea) {
                            this.$refs.jsonTextarea.focus();
                        }
                    });
                    this.validateJson();
                },

                closeEditor() {
                    this.editorOpen = false;
                    this.editorSectionId = null;
                    this.editorContent = '';
                    this.editorError = '';
                },

                validateJson() {
                    try {
                        JSON.parse(this.editorContent);
                        this.editorError = '';
                    } catch (e) {
                        this.editorError = e.message;
                    }
                },

                formatJson() {
                    try {
                        const parsed = JSON.parse(this.editorContent);
                        this.editorContent = JSON.stringify(parsed, null, 2);
                        this.editorError = '';
                    } catch (e) {
                        this.editorError = 'Impossible de formater : ' + e.message;
                    }
                },

                saveEditor() {
                    try {
                        const parsed = JSON.parse(this.editorContent);
                        const input = document.getElementById('section-content-' + this.editorSectionId);
                        if (input) {
                            input.value = JSON.stringify(parsed);
                        }
                        const form = document.getElementById(this.editorFormId);
                        if (form) {
                            form.submit();
                        }
                        this.closeEditor();
                    } catch (e) {
                        this.editorError = 'JSON invalide : ' + e.message;
                    }
                },

                insertTab(event) {
                    const textarea = event.target;
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    this.editorContent = this.editorContent.substring(0, start) + '    ' + this.editorContent.substring(end);
                    this.$nextTick(() => {
                        textarea.selectionStart = textarea.selectionEnd = start + 4;
                    });
                    this.validateJson();
                }
            }
        }
    </script>
</x-layouts.app>
