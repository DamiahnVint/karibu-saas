<x-layouts.app title="CMS — Médias">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Médias</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez les images et fichiers du site</p>
            </div>
            <x-ui.button onclick="document.getElementById('uploadModal').classList.remove('hidden')">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Upload
            </x-ui.button>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($media as $item)
                <div class="bg-white rounded-2xl border border-gray-100/80 overflow-hidden group hover:shadow-md hover:border-gray-200 transition-all duration-200">
                    <div class="aspect-square bg-gray-50 flex items-center justify-center overflow-hidden">
                        @if(str_starts_with($item->file_type, 'image/'))
                            <img src="{{ $item->url }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="text-xs text-gray-600 truncate font-medium">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->file_type }}</div>
                        <form method="POST" action="{{ route('admin.cms.media.destroy', $item) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors" onclick="return confirm('Supprimer ce média ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-gray-400 text-sm font-medium">Aucun média</p>
                    <p class="text-gray-300 text-xs mt-1">Uploadez votre premier fichier</p>
                </div>
            @endforelse
        </div>

        <div>{{ $media->links() }}</div>
    </div>

    {{-- Modal upload --}}
    <div id="uploadModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-xl" @click.outside="$el.closest('.hidden')?.classList.add('hidden')">
            <h2 class="text-xl font-bold text-gray-900 mb-1">Upload un média</h2>
            <p class="text-sm text-gray-500 mb-6">Images et PDF acceptés (max 5MB)</p>
            <form method="POST" action="{{ route('admin.cms.media.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Fichier</label>
                        <input type="file" name="file" required accept="image/*,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-royal-50 file:text-royal-700 hover:file:bg-royal-100 file:cursor-pointer file:transition-colors border border-gray-200 rounded-xl focus:ring-2 focus:ring-royal-500/20 focus:border-royal-500">
                    </div>
                    <x-ui.input name="alt_text" label="Texte alternatif" placeholder="Description de l'image" />
                    <x-ui.input name="category" label="Catégorie" value="general" />
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Annuler</button>
                    <x-ui.button type="submit" class="flex-1">Upload</x-ui.button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
