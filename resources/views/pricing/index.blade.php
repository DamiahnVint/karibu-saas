<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e5fa8">
    <meta name="description" content="Tarifs Karibu Paie — Logiciel de paie SaaS conforme CNPS/ITS. Côte d'Ivoire.">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <title>Tarifs — Karibu Paie</title>
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
        .pricing-card {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.12);
        }
        .pricing-popular {
            border: 2px solid #1e5fa8;
            position: relative;
        }
        .pricing-popular::before {
            content: 'Le plus populaire';
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #1e5fa8, #174882);
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- NAVBAR -->
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
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-royal-600 font-medium">Connexion</a>
                <a href="{{ route('landing') }}" class="text-sm bg-royal-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-royal-700 transition">Retour au site</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="py-16 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                Un prix simple,<br>
                <span class="text-royal-600">sans surprise</span>
            </h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Choisissez le plan qui correspond à votre entreprise. Tous les plans incluent la conformité CNPS, ITS et CMU.
            </p>
        </div>
    </section>

    <!-- PLANS -->
    <section class="pb-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach($plans as $plan)
                <div class="pricing-card bg-white rounded-2xl shadow-sm border {{ $plan->slug === 'professionnel' ? 'pricing-popular' : 'border-gray-200' }} p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ $plan->description }}</p>

                    <div class="mb-6">
                        @if($plan->price > 0)
                            <span class="text-4xl font-black text-gray-900">{{ number_format($plan->price, 0, ',', ' ') }}</span>
                            <span class="text-sm text-gray-500"> FCFA/mois</span>
                        @else
                            <span class="text-4xl font-black text-royal-600">Gratuit</span>
                            <span class="text-sm text-gray-500"> (15 jours)</span>
                        @endif
                    </div>

                    <div class="text-sm text-gray-600 mb-6">
                        <span class="font-semibold">{{ $plan->max_employees }} employés maximum</span>
                    </div>

                    <ul class="space-y-3 mb-8">
                        @foreach($plan->features ?? [] as $feature)
                        <li class="flex items-start gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    @if($plan->slug === 'enterprise')
                        <a href="{{ route('demo.index') }}" class="block w-full text-center py-3 rounded-xl font-semibold border-2 border-royal-600 text-royal-600 hover:bg-royal-50 transition">
                            Contacter l'équipe
                        </a>
                    @else
                        <a href="{{ route('checkout.index', ['plan' => $plan->slug]) }}" class="block w-full text-center py-3 rounded-xl font-semibold {{ $plan->slug === 'professionnel' ? 'bg-royal-600 text-white hover:bg-royal-700' : 'bg-gray-900 text-white hover:bg-gray-800' }} transition">
                            {{ $plan->is_trial ? 'Commencer l\'essai' : 'Choisir ce plan' }}
                        </a>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-10">Questions fréquentes</h2>
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">L'essai gratuit est-il vraiment gratuit ?</h3>
                    <p class="text-sm text-gray-500">Oui, pendant 15 jours vous avez accès à toutes les fonctionnalités. Aucune carte bancaire n'est requise.</p>
                </div>
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Puis-je changer de plan ?</h3>
                    <p class="text-sm text-gray-500">Oui, vous pouvez upgrader ou downgrader à tout moment. Le changement est immédiat.</p>
                </div>
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Comment fonctionne le paiement ?</h3>
                    <p class="text-sm text-gray-500">Pour l'instant, le paiement se fait par virement ou Mobile Money. Stripe sera bientôt disponible.</p>
                </div>
                <div class="pb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Puis-je annuler à tout moment ?</h3>
                    <p class="text-sm text-gray-500">Oui, sans engagement. Votre accès reste actif jusqu'à la fin de la période payée.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-8 bg-gray-50 text-center">
        <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Karibu Technologies. Tous droits réservés.</p>
    </footer>

</body>
</html>
