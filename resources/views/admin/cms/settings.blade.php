<x-layouts.app title="CMS — Paramètres">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-gray-900">Paramètres du site</h1>
            <p class="text-gray-500 text-sm mt-1">Configurez les informations globales de votre site</p>
        </div>

        @if(session('success'))
            <x-ui.alert type="success" :message="session('success')" />
        @endif

        <form method="POST" action="{{ route('admin.cms.settings.update') }}">
            @csrf
            @method('PUT')

            @foreach($groupsList as $group)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                    <h2 class="font-bold text-gray-900 mb-4 uppercase text-sm tracking-wider">{{ $group }}</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach(($groups[$group] ?? []) as $setting)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $setting->key }}</label>
                                <input type="hidden" name="settings[{{ $setting->key }}][key]" value="{{ $setting->key }}">
                                <input type="hidden" name="settings[{{ $setting->key }}][group]" value="{{ $setting->group }}">

                                @if($setting->type === 'textarea')
                                    <textarea name="settings[{{ $setting->key }}][value]" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">{{ $setting->value }}</textarea>
                                @elseif($setting->type === 'color')
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}" class="w-12 h-10 rounded border border-gray-200">
                                        <input type="text" value="{{ $setting->value }}" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-mono">
                                    </div>
                                @else
                                    <input type="text" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-royal-500">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl font-semibold text-sm">Sauvegarder tous les paramètres</button>
        </form>
    </div>
</x-layouts.app>
