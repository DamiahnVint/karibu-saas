<x-layouts.app title="CMS — Soumission">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('admin.cms.forms.index', ['type' => $submission->form_type]) }}" class="text-sm text-gray-400 hover:text-royal-600">&larr; Retour</a>

        <div class="bg-white rounded-2xl border border-gray-100 p-8 mt-4">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-black text-gray-900">
                        {{ $submission->form_type === 'contact' ? 'Message de contact' : 'Demande de démo' }}
                    </h1>
                    <p class="text-sm text-gray-400">Reçu le {{ $submission->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if(!$submission->is_read)
                    <form method="POST" action="{{ route('admin.cms.forms.read', $submission) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-sm text-orange-600 hover:text-orange-800 font-semibold">Marquer comme lu</button>
                    </form>
                @endif
            </div>

            <div class="space-y-4">
                @foreach($submission->data as $key => $value)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ $key }}</label>
                        <div class="text-gray-900">{{ $value }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">IP: {{ $submission->ip_address ?? 'N/A' }}</span>
                <form method="POST" action="{{ route('admin.cms.forms.destroy', $submission) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
