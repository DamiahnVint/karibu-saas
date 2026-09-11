<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e5fa8">
    <meta name="description" content="Connexion — Karibu Paie">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Karibu Paie">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/icons/favicon.png">
    <title>Connexion — Karibu Paie</title>
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
        [x-cloak] { display: none !important; }

        .filigrane {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url('/images/code-engineering.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.33;
            mix-blend-mode: multiply;
        }

        @keyframes orbFloat1 { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(30px, -40px) scale(1.05); } 66% { transform: translate(-20px, 20px) scale(0.95); } }
        @keyframes orbFloat2 { 0%, 100% { transform: translate(0, 0) scale(1); } 33% { transform: translate(-40px, 30px) scale(0.95); } 66% { transform: translate(25px, -35px) scale(1.05); } }
        @keyframes orbFloat3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, -50px); } }
        @keyframes cardReveal { 0% { opacity: 0; transform: translateY(40px) scale(0.96); filter: blur(8px); } 100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); } }
        @keyframes fieldSlideIn { 0% { opacity: 0; transform: translateX(-20px); } 100% { opacity: 1; transform: translateX(0); } }
        @keyframes glowPulse { 0%, 100% { box-shadow: 0 0 30px rgba(30, 95, 168, 0.15), 0 0 60px rgba(30, 95, 168, 0.05); } 50% { box-shadow: 0 0 40px rgba(30, 95, 168, 0.25), 0 0 80px rgba(30, 95, 168, 0.1); } }
        @keyframes borderGlow { 0%, 100% { border-color: rgba(255,255,255,0.15); } 50% { border-color: rgba(255,255,255,0.25); } }
        @keyframes logoReveal { 0% { opacity: 0; transform: scale(0.5) rotate(-10deg); } 60% { transform: scale(1.1) rotate(2deg); } 100% { opacity: 1; transform: scale(1) rotate(0deg); } }
        @keyframes textSlideUp { 0% { opacity: 0; transform: translateY(15px); } 100% { opacity: 1; transform: translateY(0); } }

        .orb-1 { animation: orbFloat1 12s ease-in-out infinite; }
        .orb-2 { animation: orbFloat2 15s ease-in-out infinite; }
        .orb-3 { animation: orbFloat3 18s ease-in-out infinite; }
        .card-reveal { animation: cardReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .field-slide { animation: fieldSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .glow-pulse { animation: glowPulse 4s ease-in-out infinite; }
        .border-glow { animation: borderGlow 3s ease-in-out infinite; }
        .logo-reveal { animation: logoReveal 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .text-slide { animation: textSlideUp 0.5s ease-out forwards; opacity: 0; }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 0 20px rgba(30, 95, 168, 0.2);
        }
        .input-glass::placeholder { color: rgba(255, 255, 255, 0.35); }

        .btn-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
            transition: all 0.3s ease;
        }
        .btn-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-glass:active { transform: translateY(0); }

        .link-glow { transition: all 0.3s ease; }
        .link-glow:hover { text-shadow: 0 0 12px rgba(147, 197, 253, 0.5); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-royal-950 via-royal-900 to-royal-800 flex items-center justify-center overflow-hidden relative">

    <!-- Filigrane -->
    <div class="filigrane"></div>

    <!-- Orbes flottantes -->
    <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-royal-500/10 rounded-full blur-3xl orb-1"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-400/8 rounded-full blur-3xl orb-2"></div>
    <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-cyan-400/6 rounded-full blur-3xl orb-3"></div>

    <!-- Contenu principal -->
    <div class="relative z-10 w-full max-w-md mx-4">

        <!-- Logo -->
        <div class="text-center mb-8 logo-reveal" style="animation-delay: 0.1s;">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3">
                <div class="w-14 h-14 bg-gradient-to-br from-royal-500 to-royal-300 rounded-2xl flex items-center justify-center shadow-xl shadow-royal-500/20">
                    <span class="text-white font-black text-3xl">K</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-2xl text-white tracking-tight">KARIBU</span>
                    <span class="text-[10px] font-semibold tracking-[0.3em] text-white/40">TECHNOLOGIES</span>
                </div>
            </a>
        </div>

        <!-- Carte glass -->
        <div class="glass-card rounded-3xl p-8 sm:p-10 card-reveal glow-pulse border-glow" style="animation-delay: 0.3s;">

            <!-- Titre -->
            <div class="text-slide mb-8" style="animation-delay: 0.5s;">
                <h1 class="text-2xl font-bold text-white text-center">Bienvenue</h1>
                <p class="text-white/50 text-center text-sm mt-2">Connectez-vous &agrave; votre espace</p>
            </div>

            @if(session('success'))
                <div class="bg-green-500/15 border border-green-500/30 rounded-xl px-4 py-3 mb-6 text-green-300 text-sm text-slide" style="animation-delay: 0.55s;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/15 border border-red-500/30 rounded-xl px-4 py-3 mb-6 text-red-300 text-sm text-slide" style="animation-delay: 0.55s;">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false }" x-on:submit="loading = true">
                @csrf

                <!-- Email -->
                <div class="field-slide" style="animation-delay: 0.6s;">
                    <label for="email" class="block text-sm font-medium text-white/70 mb-2">Adresse email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="input-glass w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
                        placeholder="vous@entreprise.com">
                </div>

                <!-- Mot de passe -->
                <div class="field-slide" style="animation-delay: 0.7s;">
                    <label for="password" class="block text-sm font-medium text-white/70 mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password" required
                        class="input-glass w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none"
                        placeholder="••••••••">
                </div>

                <!-- Souvenir + Mot de passe oublie -->
                <div class="flex items-center justify-between field-slide" style="animation-delay: 0.8s;">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1"
                            class="w-4 h-4 rounded border-white/20 bg-white/10 text-royal-500 focus:ring-royal-500 focus:ring-offset-0">
                        <span class="text-sm text-white/60">Se souvenir de moi</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-300 hover:text-blue-200 link-glow">
                        Mot de passe oubli&eacute; ?
                    </a>
                </div>

                <!-- Bouton -->
                <div class="field-slide" style="animation-delay: 0.9s;">
                    <button type="submit" class="btn-glass w-full py-3.5 rounded-xl font-bold text-royal-700 text-sm relative overflow-hidden">
                        <span x-show="!loading">Se connecter</span>
                        <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Connexion...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Lien inscription -->
            <div class="text-slide mt-6 text-center" style="animation-delay: 1s;">
                <p class="text-sm text-white/40">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-blue-300 hover:text-blue-200 font-medium link-glow">
                        Cr&eacute;er un compte
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-slide mt-8 text-center" style="animation-delay: 1.1s;">
            <p class="text-xs text-white/25">&copy; {{ date('Y') }} Karibu Technologies. Tous droits r&eacute;serv&eacute;s.</p>
        </div>
    </div>

    <!-- Particules subtilles -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute w-1 h-1 bg-white/20 rounded-full" style="top: 15%; left: 20%; animation: orbFloat1 8s ease-in-out infinite;"></div>
        <div class="absolute w-1.5 h-1.5 bg-white/15 rounded-full" style="top: 70%; left: 75%; animation: orbFloat2 10s ease-in-out infinite;"></div>
        <div class="absolute w-1 h-1 bg-white/10 rounded-full" style="top: 40%; left: 85%; animation: orbFloat3 12s ease-in-out infinite;"></div>
        <div class="absolute w-0.5 h-0.5 bg-white/25 rounded-full" style="top: 80%; left: 30%; animation: orbFloat1 9s ease-in-out infinite;"></div>
        <div class="absolute w-1 h-1 bg-white/10 rounded-full" style="top: 25%; left: 60%; animation: orbFloat2 11s ease-in-out infinite;"></div>
    </div>

    <!-- Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
    <!-- Anti-inspection -->
    <script>
        document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j' || e.key === 'C' || e.key === 'c')) || (e.ctrlKey && (e.key === 'U' || e.key === 'u' || e.key === 'S' || e.key === 's'))) {
                e.preventDefault();
                return false;
            }
        });
        document.addEventListener('dragstart', function(e) { e.preventDefault(); });
        document.addEventListener('selectstart', function(e) { if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') { e.preventDefault(); } });
    </script>
</body>
</html>