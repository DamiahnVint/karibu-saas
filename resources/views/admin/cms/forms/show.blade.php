<x-layouts.app title="CMS — Soumission">
    <div class="max-w-3xl space-y-6">
        <div>
            <a href="{{ route('admin.cms.forms.index', ['type' => $submission->form_type]) }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-royal-600 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Retour
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100/80 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-black text-gray-900">
                        {{ $submission->form_type === 'contact' ? 'Message de contact' : 'Demande de démo' }}
                    </h1>
                    <p class="text-sm text-gray-400 mt-1">Reçu le {{ $submission->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if(!$submission->is_read)
                    <form method="POST" action="{{ route('admin.cms.forms.read', $submission) }}">
                        @csrf
                        @method('PATCH')
                        <x-ui.button type="submit" variant="secondary" size="sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Marquer comme lu
                        </x-ui.button>
                    </form>
                @endif
            </div>

            <div class="space-y-4">
                @foreach($submission->data as $key => $value)
                    <div class="bg-gray-50/50 rounded-xl p-4">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $key }}</label>
                        <div class="text-gray-900 font-medium">{{ $value }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400 font-mono">IP: {{ $submission->ip_address ?? 'N/A' }}</span>
                <form method="POST" action="{{ route('admin.cms.forms.destroy', $submission) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-semibold transition-colors" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
