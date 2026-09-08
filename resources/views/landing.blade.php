<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e40af">
    <meta name="description" content="Karibu Technologies — Suite logicielle SaaS made in CI. Paie, Compta, Gestion Scolaire.">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="/manifest.json">
    <title>Karibu Technologies — La tech au service de votre business</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(30px); }
        .fade-in-left { animation: fadeInLeft 0.8s ease-out forwards; opacity: 0; transform: translateX(-30px); }
        .fade-in-right { animation: fadeInRight 0.8s ease-out forwards; opacity: 0; transform: translateX(30px); }
        .slide-in { animation: slideIn 0.6s ease-out forwards; }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInLeft { to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { to { opacity: 1; transform: translateX(0); } }
        @keyframes slideIn { from { transform: translateY(-100%); } to { transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); } 50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); } }
        .float { animation: float 6s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .gradient-text { background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); transition: all 0.3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #2563eb, #1d4ed8); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4); }
        .btn-outline { border: 2px solid #3b82f6; color: #3b82f6; transition: all 0.3s ease; }
        .btn-outline:hover { background: #3b82f6; color: white; transform: translateY(-2px); }
        .nav-scrolled { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
        .section-hidden { opacity: 0; transform: translateY(40px); transition: all 0.8s ease; }
        .section-visible { opacity: 1; transform: translateY(0); }
        .particle { position: absolute; border-radius: 50%; background: rgba(59, 130, 246, 0.1); pointer-events: none; }
    </style>
</head>
<body class="bg-white text-gray-900 overflow-x-hidden" x-data="{ mobileMenu: false, scrolled: false }"
      @scroll.window="scrolled = (window.scrollY > 50)">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300"
         :class="scrolled ? 'nav-scrolled py-3' : 'bg-transparent py-5'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">K</span>
                </div>
                <span class="font-bold text-xl" :class="scrolled ? 'text-gray-900' : 'text-white'">Karibu</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#produits" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-blue-600' : 'text-white/80 hover:text-white'">Produits</a>
                <a href="#avantages" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-blue-600' : 'text-white/80 hover:text-white'">Avantages</a>
                <a href="#pricing" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-blue-600' : 'text-white/80 hover:text-white'">Tarifs</a>
                <a href="#contact" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-blue-600' : 'text-white/80 hover:text-white'">Contact</a>
                <a href="/login" class="btn-primary text-white px-6 py-2.5 rounded-xl font-semibold">Connexion</a>
            </div>

            <button @click="mobileMenu = !mobileMenu" class="md:hidden" :class="scrolled ? 'text-gray-900' : 'text-white'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-white rounded-b-2xl shadow-xl mx-4 mt-2 p-4">
            <a href="#produits" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Produits</a>
            <a href="#avantages" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Avantages</a>
            <a href="#pricing" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Tarifs</a>
            <a href="#contact" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Contact</a>
            <a href="/login" class="block mt-2 btn-primary text-white text-center px-6 py-3 rounded-xl font-semibold">Connexion</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900">
        <!-- Particles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle w-2 h-2 top-20 left-20 float" style="animation-delay: 0s;"></div>
            <div class="particle w-3 h-3 top-40 right-32 float" style="animation-delay: 1s;"></div>
            <div class="particle w-4 h-4 bottom-32 left-1/4 float" style="animation-delay: 2s;"></div>
            <div class="particle w-2 h-2 top-1/3 right-1/4 float" style="animation-delay: 0.5s;"></div>
            <div class="particle w-3 h-3 bottom-20 right-20 float" style="animation-delay: 1.5s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="fade-in-up" style="animation-delay: 0.2s;">
                <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm font-medium px-4 py-2 rounded-full mb-6 border border-white/20">
                    Made in Cote d'Ivoire
                </span>
            </div>
            <h1 class="fade-in-up text-5xl md:text-7xl font-black text-white mb-6 leading-tight" style="animation-delay: 0.4s;">
                La technologie<br>
                <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">au service</span><br>
                de votre business
            </h1>
            <p class="fade-in-up text-xl md:text-2xl text-white/70 mb-10 max-w-2xl mx-auto" style="animation-delay: 0.6s;">
                Suite logicielle SaaS pour entreprises ivoiriennes. Paie, Compta, RH — conforme aux normes locales.
            </p>
            <div class="fade-in-up flex flex-col sm:flex-row gap-4 justify-center" style="animation-delay: 0.8s;">
                <a href="#produits" class="btn-primary text-white px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center justify-center gap-2">
                    Decouvrir nos solutions
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="#contact" class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all inline-flex items-center justify-center gap-2">
                    Nous contacter
                </a>
            </div>

            <!-- Stats -->
            <div class="fade-in-up mt-20 grid grid-cols-3 gap-8 max-w-lg mx-auto" style="animation-delay: 1s;">
                <div>
                    <div class="text-3xl font-black text-white">100%</div>
                    <div class="text-white/50 text-sm">Made in CI</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">FCFA</div>
                    <div class="text-white/50 text-sm">Pricing local</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">24/7</div>
                    <div class="text-white/50 text-sm">Support</div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- PRODUITS -->
    <section id="produits" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 section-hidden">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Nos produits</span>
                <h2 class="text-4xl md:text-5xl font-black mt-3 mb-5">Des solutions qui<br><span class="gradient-text">transforment votre business</span></h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Chaque produit est concu pour repondre aux besoins specifiques des entreprises ivoiriennes et ouest-africaines.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- KARIBU PAIE -->
                <div class="section-hidden bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-bl-full"></div>
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-4">EN COURS DE DEVELOPPEMENT</div>
                    <h3 class="text-2xl font-bold mb-3">Karibu Paie</h3>
                    <p class="text-gray-500 mb-6">Gestion de la paie conforme aux normes ivoiriennes. Calcul CNPS, ITS, bulletins PDF, declarations sociales automatisees.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Calcul CNPS + ITS automatique
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Bulletins PDF standard CI
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Declarations CNPS
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Multi-entreprises
                        </li>
                    </ul>
                    <div class="text-2xl font-black text-blue-600 mb-2">25 000 FCFA<small class="text-sm font-normal text-gray-400">/mois</small></div>
                </div>

                <!-- KARIBU SCOLAIRE -->
                <div class="section-hidden bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-purple-500/10 to-transparent rounded-bl-full"></div>
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full mb-4">BIENTOT DISPONIBLE</div>
                    <h3 class="text-2xl font-bold mb-3">Karibu Scolaire</h3>
                    <p class="text-gray-500 mb-6">Gestion scolaire complete. Inscriptions, notes, bulletins, paiements de frais, communication parents-eleves.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Inscriptions & eleves
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Grille de notes & bulletins
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Paiements frais scolaires
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Portail parents
                        </li>
                    </ul>
                    <div class="text-2xl font-black text-purple-600 mb-2">30 000 FCFA<small class="text-sm font-normal text-gray-400">/mois</small></div>
                </div>

                <!-- KARIBU VTC -->
                <div class="section-hidden bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-green-500/10 to-transparent rounded-bl-full"></div>
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-4">ACTIF</div>
                    <h3 class="text-2xl font-bold mb-3">Karibu VTC</h3>
                    <p class="text-gray-500 mb-6">Mise en relation clients et chauffeurs VTC. Reservation en temps reel, suivi GPS, paiement mobile.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Reservation temps reel
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Suivi GPS
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Paiement Wave / Orange Money
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            3 villes couvertes
                        </li>
                    </ul>
                    <a href="https://karibu.co.ci" target="_blank" class="block text-center bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition-all">
                        Decouvrir VTC
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- AVANTAGES -->
    <section id="avantages" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 section-hidden">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Pourquoi Karibu</span>
                <h2 class="text-4xl md:text-5xl font-black mt-3 mb-5">Concu pour<br><span class="gradient-text">les entreprises ivoiriennes</span></h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100/50 card-hover">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Made in CI</h3>
                    <p class="text-gray-500">Concu par des Ivoiriens, pour les Ivoiriens. Pas de solution importee qui ne comprend pas votre realite.</p>
                </div>

                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100/50 card-hover">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Conforme normes locales</h3>
                    <p class="text-gray-500">CNPS, ITS, CMU, OHADA — tout est integre. Pas de configuration complexe.</p>
                </div>

                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-green-50 to-green-100/50 card-hover">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Prix en FCFA</h3>
                    <p class="text-gray-500">Pas de prix en USD qui changent chaque mois. Tarification fixe en FCFA, transparente.</p>
                </div>

                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100/50 card-hover">
                    <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Support local</h3>
                    <p class="text-gray-500">Pas de support en anglais depuis l'Inde. equipe francophone, basee en Cote d'Ivoire.</p>
                </div>

                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-red-50 to-red-100/50 card-hover">
                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Rapide & moderne</h3>
                    <p class="text-gray-500">Interface moderne, pas de lourdeurs legacy. Application web + mobile.</p>
                </div>

                <div class="section-hidden p-8 rounded-2xl bg-gradient-to-br from-teal-50 to-teal-100/50 card-hover">
                    <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Securise</h3>
                    <p class="text-gray-500">Donnees cryptees, authentification securisee, backups automatiques. Vos donnees sont protegees.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <section id="pricing" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 section-hidden">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Tarification</span>
                <h2 class="text-4xl md:text-5xl font-black mt-3 mb-5">Des prix adaptes<br><span class="gradient-text">a votre entreprise</span></h2>
                <p class="text-gray-500 text-lg">Pas de frais caches. Pas de surprises. Prix en FCFA.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- ESSENTIEL -->
                <div class="section-hidden bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100">
                    <h3 class="text-xl font-bold mb-2">Essentiel</h3>
                    <p class="text-gray-400 text-sm mb-6">Pour les petites entreprises</p>
                    <div class="text-4xl font-black text-blue-600 mb-1">25 000</div>
                    <div class="text-gray-400 text-sm mb-8">FCFA / mois</div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Jusqu'a 25 employes
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Calcul CNPS + ITS
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Bulletins PDF
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Declarations CNPS
                        </li>
                    </ul>
                    <a href="#contact" class="block text-center btn-outline py-3 rounded-xl font-semibold">Commencer</a>
                </div>

                <!-- PROFESSIONNEL -->
                <div class="section-hidden bg-gradient-to-br from-blue-600 to-purple-600 rounded-3xl p-8 shadow-xl card-hover text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-bl-xl">POPULAIRE</div>
                    <h3 class="text-xl font-bold mb-2">Professionnel</h3>
                    <p class="text-white/60 text-sm mb-6">Pour les entreprises en croissance</p>
                    <div class="text-4xl font-black mb-1">45 000</div>
                    <div class="text-white/60 text-sm mb-8">FCFA / mois</div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-white/80">
                            <svg class="w-5 h-5 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Jusqu'a 100 employes
                        </li>
                        <li class="flex items-center gap-2 text-sm text-white/80">
                            <svg class="w-5 h-5 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Tout du plan Essentiel
                        </li>
                        <li class="flex items-center gap-2 text-sm text-white/80">
                            <svg class="w-5 h-5 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Module RH complet
                        </li>
                        <li class="flex items-center gap-2 text-sm text-white/80">
                            <svg class="w-5 h-5 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Multi-utilisateurs
                        </li>
                        <li class="flex items-center gap-2 text-sm text-white/80">
                            <svg class="w-5 h-5 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            API access
                        </li>
                    </ul>
                    <a href="#contact" class="block text-center bg-white text-blue-600 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all">Commencer</a>
                </div>

                <!-- ENTERPRISE -->
                <div class="section-hidden bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100">
                    <h3 class="text-xl font-bold mb-2">Enterprise</h3>
                    <p class="text-gray-400 text-sm mb-6">Pour les grandes organisations</p>
                    <div class="text-4xl font-black text-purple-600 mb-1">Sur mesure</div>
                    <div class="text-gray-400 text-sm mb-8">Contactez-nous</div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Employes illimites
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Tout du plan Pro
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Deploiement dedie
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Support 24/7
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            SLA garanti
                        </li>
                    </ul>
                    <a href="#contact" class="block text-center btn-outline py-3 rounded-xl font-semibold">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT / CTA -->
    <section id="contact" class="py-24 bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle w-3 h-3 top-20 left-10 float" style="animation-delay: 0s;"></div>
            <div class="particle w-4 h-4 bottom-20 right-20 float" style="animation-delay: 1s;"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="section-hidden text-4xl md:text-5xl font-black text-white mb-6">Pret a digitaliser<br>votre entreprise ?</h2>
            <p class="section-hidden text-xl text-white/70 mb-10">Rejoignez les entreprises ivoiriennes qui font confiance a Karibu Technologies.</p>
            <div class="section-hidden flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:contact@karibu.co.ci" class="btn-primary text-white px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    contact@karibu.co.ci
                </a>
                <a href="https://karibu.co.ci" target="_blank" class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all inline-flex items-center justify-center gap-2">
                    karibu.co.ci
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">K</span>
                        </div>
                        <span class="font-bold text-lg">Karibu Technologies</span>
                    </div>
                    <p class="text-gray-400 text-sm">La technologie au service de votre business. Suite SaaS made in Cote d'Ivoire.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Produits</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#produits" class="hover:text-white transition-colors">Karibu Paie</a></li>
                        <li><a href="#produits" class="hover:text-white transition-colors">Karibu Scolaire</a></li>
                        <li><a href="https://karibu.co.ci" target="_blank" class="hover:text-white transition-colors">Karibu VTC</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Entreprise</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#avantages" class="hover:text-white transition-colors">A propos</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="mailto:contact@karibu.co.ci" class="hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Conditions</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Confidentialite</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 text-sm">&copy; 2026 Karibu Technologies. Tous droits reserves.</p>
                <p class="text-gray-500 text-sm">Abidjan, Cote d'Ivoire</p>
            </div>
        </div>
    </footer>

    <!-- PWA Install Banner -->
    <div x-data="{ showInstall: false, deferredPrompt: null }"
         x-init="window.addEventListener('beforeinstallprompt', (e) => { e.preventDefault(); deferredPrompt = e; showInstall = true; })"
         x-show="showInstall"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed bottom-0 left-0 right-0 z-50 p-4">
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border border-gray-100">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shrink-0">
                <span class="text-white font-bold">K</span>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-sm">Installer Karibu</p>
                <p class="text-gray-500 text-xs">Acces rapide depuis votre ecran d'accueil</p>
            </div>
            <button @click="deferredPrompt.prompt(); deferredPrompt.userChoice.then((choice) => { showInstall = false; })"
                    class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
                Installer
            </button>
            <button @click="showInstall = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Intersection Observer for scroll animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('section-visible');
                        }, index * 100);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.section-hidden').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
