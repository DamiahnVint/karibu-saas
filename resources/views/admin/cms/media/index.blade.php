<x-layouts.app title="CMS — Médias">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Médias</h1>
                <p class="text-gray-500 text-sm mt-1">Gérez les images et fichiers du site</p>
            </div>
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="btn-primary text-white px-4 py-2 rounded-xl font-semibold text-sm">
                + Upload
            </button>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($media as $item)
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden group">
                    <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if(str_starts_with($item->file_type, 'image/'))
                            <img src="{{ $item->url }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                        @else
                            <span class="text-3xl">📄</span>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="text-xs text-gray-500 truncate">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->file_type }}</div>
                        <form method="POST" action="{{ route('admin.cms.media.destroy', $item) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700" onclick="return confirm('Supprimer ce média ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-400 text-sm text-center py-12">Aucun média. Uploadez-en un !</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $media->links() }}</div>
    </div>

    <div id="uploadModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Upload un média</h2>
            <form method="POST" action="{{ route('admin.cms.media.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fichier (max 5MB)</label>
                        <input type="file" name="file" required accept="image/*,.pdf" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Texte alternatif</label>
                        <input type="text" name="alt_text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm" placeholder="Description de l'image">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Catégorie</label>
                        <input type="text" name="category" value="general" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold text-sm">Annuler</button>
                    <button type="submit" class="flex-1 btn-primary text-white py-2.5 rounded-xl font-semibold text-sm">Upload</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
