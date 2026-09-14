<x-layouts.app :title="'Départements'">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Départements</h1>
        <p class="text-sm text-gray-500">{{ $departments->count() }} département(s)</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Liste</h2>
            <form method="POST" action="{{ route('paie.departments.store') }}" class="flex gap-2" x-data="{ show: false }">
                @csrf
                <button type="button" @click="show = !show" class="text-sm text-royal-600 hover:text-royal-800 font-semibold">+ Ajouter</button>
                <div x-show="show" x-transition class="flex gap-2">
                    <input type="text" name="name" placeholder="Nom du département" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm" required>
                    <button type="submit" class="bg-royal-500 text-white px-3 py-1.5 rounded-lg text-sm">OK</button>
                </div>
            </form>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($departments as $dept)
                <div class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition">
                    <div>
                        <span class="font-semibold text-gray-900 text-sm">{{ $dept->name }}</span>
                        <span class="text-xs text-gray-400 ml-2">({{ $dept->employees->count() }} employés)</span>
                    </div>
                    <form method="POST" action="{{ route('paie.departments.destroy', $dept->id) }}" onsubmit="return confirm('Supprimer ce département ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 text-xs">Supprimer</button>
                    </form>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">Aucun département.</div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
