<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e5fa8">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <title>Checkout — Karibu Paie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        royal: {
                            50: '#eef4fb', 100: '#d4e4f7', 200: '#a9c9ef', 300: '#7eafe7',
                            400: '#5394df', 500: '#2879d7', 600: '#1e5fa8', 700: '#174882',
                            800: '#10325c', 900: '#0a1d38', 950: '#060f1f',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('pricing') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-royal-600 to-royal-400 rounded-xl flex items-center justify-center">
                    <span class="text-white font-black text-lg">K</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-lg tracking-tight text-gray-900">KARIBU</span>
                    <span class="text-[9px] font-semibold tracking-[0.25em] text-gray-400">PAIE</span>
                </div>
            </a>
            <a href="{{ route('pricing') }}" class="text-sm text-gray-500 hover:text-royal-600 font-medium">&larr; Retour aux tarifs</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Finaliser votre inscription</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- FORMULAIRE -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6" x-data="{ loading: false }" x-on:submit="loading = true">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    <!-- Entreprise -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Votre entreprise</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise *</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                    placeholder="Ma Société SARL">
                                @error('company_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIF (optionnel)</label>
                                    <input type="text" name="company_nif" value="{{ old('company_nif') }}"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="123456789">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse (optionnel)</label>
                                    <input type="text" name="company_address" value="{{ old('company_address') }}"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="Abidjan, Cocody">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Votre compte</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="Jean Dupont">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone (optionnel)</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="+225 07 00 00 00">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                    placeholder="jean@entreprise.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                                    <input type="password" name="password" required
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="8 caractères minimum">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer *</label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-royal-500 focus:border-royal-500"
                                        placeholder="Retapez le mot de passe">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <button type="submit" class="w-full bg-royal-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-royal-700 transition flex items-center justify-center gap-2" :disabled="loading">
                        <span x-show="!loading">Créer mon compte et commencer l'essai</span>
                        <span x-show="loading" x-cloak class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Création en cours...
                        </span>
                    </button>
                </form>
            </div>

            <!-- RÉSUMÉ -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h3 class="font-bold text-gray-900 mb-4">Votre plan</h3>
                    <div class="border-b border-gray-100 pb-4 mb-4">
                        <p class="text-lg font-bold text-royal-600">{{ $plan->name }}</p>
                        @if($plan->price > 0)
                            <p class="text-2xl font-black text-gray-900">{{ number_format($plan->price, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">FCFA/mois</span></p>
                        @else
                            <p class="text-lg font-bold text-green-600">Gratuit pendant {{ $plan->trial_days }} jours</p>
                        @endif
                    </div>
                    <ul class="space-y-2 text-sm text-gray-600 mb-6">
                        @foreach(array_slice($plan->features ?? [], 0, 5) as $feature)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-xs text-gray-400">Aucune carte bancaire requise. Annulation à tout moment.</p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
