<x-layouts.app title="CMS — Paramètres">
    <div class="max-w-4xl space-y-6">
        <div>
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
                <div class="bg-white rounded-2xl border border-gray-100/80 p-6 mb-5">
                    <h2 class="font-bold text-gray-900 mb-5 uppercase text-xs tracking-wider text-gray-500">{{ $group }}</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach(($groups[$group] ?? []) as $setting)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ $setting->key }}</label>
                                <input type="hidden" name="settings[{{ $setting->key }}][key]" value="{{ $setting->key }}">
                                <input type="hidden" name="settings[{{ $setting->key }}][group]" value="{{ $setting->group }}">

                                @if($setting->type === 'textarea')
                                    <textarea name="settings[{{ $setting->key }}][value]" rows="3" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400">{{ $setting->value }}</textarea>
                                @elseif($setting->type === 'color')
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}" class="w-11 h-10 rounded-lg border border-gray-200 cursor-pointer">
                                        <input type="text" value="{{ $setting->value }}" class="flex-1 rounded-xl border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm font-mono focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20">
                                    </div>
                                @else
                                    <input type="text" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all duration-200 focus:border-royal-500 focus:ring-2 focus:ring-royal-500/20 focus:bg-white sm:text-sm placeholder:text-gray-400">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <x-ui.button type="submit">Sauvegarder tous les paramètres</x-ui.button>
        </form>
    </div>
</x-layouts.app>
