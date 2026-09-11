<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e5fa8">
    <title>Réserver une démo — Karibu Paie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { royal: { 50:'#eef4fb',100:'#d4e4f7',200:'#a9c9ef',300:'#7eafe7',400:'#5394df',500:'#2879d7',600:'#1e5fa8',700:'#174882',800:'#10325c',900:'#0a1d38',950:'#060f1f' } } } }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-royal-600 to-royal-400 rounded-xl flex items-center justify-center">
                    <span class="text-white font-black text-lg">K</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-lg tracking-tight text-gray-900">KARIBU</span>
                    <span class="text-[9px] font-semibold tracking-[0.25em] text-gray-400">PAIE</span>
                </div>
            </a>
            <a href="{{ route('pricing') }}" class="text-sm bg-royal-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-royal-700 transition">Voir les tarifs</a>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-900 mb-3">Réserver une démo</h1>
            <p class="text-gray-500">Découvrez Karibu Paie en 15 minutes. Pas d'engagement, pas de carte bancaire.</p>
        </div>

        <form method="POST" action="{{ route('demo.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 space-y-5" x-data="{ loading: false }" x-on:submit="loading = true">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Votre nom *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="Jean Dupont">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="jean@entreprise.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise *</label>
                    <input type="text" name="company" value="{{ old('company') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="Ma Société SARL">
                    @error('company') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'employés *</label>
                    <select name="employees" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500">
                        <option value="">Sélectionnez</option>
                        <option value="1-5">1 à 5</option>
                        <option value="6-15">6 à 15</option>
                        <option value="16-50">16 à 50</option>
                        <option value="51-100">51 à 100</option>
                        <option value="100+">Plus de 100</option>
                    </select>
                    @error('employees') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone (optionnel)</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="+225 07 00 00 00">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message (optionnel)</label>
                <textarea name="message" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500" placeholder="Dites-nous ce que vous souhaitez voir...">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="w-full bg-royal-600 text-white py-3.5 rounded-xl font-bold hover:bg-royal-700 transition" :disabled="loading">
                <span x-show="!loading">Réserver ma démo gratuite</span>
                <span x-show="loading" x-cloak>Envoi en cours...</span>
            </button>
            <p class="text-xs text-center text-gray-400">Nous vous contacterons sous 24h pour confirmer le créneau.</p>
        </form>
    </div>

</body>
</html>
