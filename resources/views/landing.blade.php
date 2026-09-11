<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e5fa8">
    <meta name="description" content="Karibu Paie — Logiciel de paie SaaS conforme CNPS/ITS. Côte d'Ivoire.">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Karibu Paie">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <title>Karibu Technologies — La technologie au service de votre business</title>
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
        html { scroll-behavior: smooth; }
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(30px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .float { animation: float 6s ease-in-out infinite; }
        .gradient-text { background: linear-gradient(135deg, #93c5fd, #67e8f9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* FILIGRANE — visible à 33% sur TOUS les fonds */
        .filigrane {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url('/images/code-engineering.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.33;
            mix-blend-mode: multiply;
        }
        .filigrane-light {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url('/images/code-engineering.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.25;
            mix-blend-mode: multiply;
        }

        /* NAVBAR */
        .nav-scrolled {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            border-bottom: 1px solid rgba(255,255,255,0.8);
        }

        /* BOUTONS */
        .btn-primary {
            background: linear-gradient(135deg, #1e5fa8, #174882);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2879d7, #1e5fa8);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(30, 95, 168, 0.4);
        }
        .btn-outline {
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }

        /* CARTES PRODUITS — Design premium avec animations */
        .product-card {
            position: relative;
            background: white;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid #e5e7eb;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            overflow: hidden;
        }
        .product-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--card-color, #1e5fa8), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .product-card::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, var(--card-glow, rgba(30,95,168,0.06)) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }
        .product-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 60px rgba(0,0,0,0.12), 0 0 40px var(--card-shadow, rgba(30,95,168,0.1));
            border-color: var(--card-color, #1e5fa8);
        }
        .product-card:hover::before { opacity: 1; }
        .product-card:hover::after { opacity: 1; }
        .product-card:hover .card-icon {
            transform: scale(1.15) rotate(-5deg);
            box-shadow: 0 8px 25px var(--card-shadow, rgba(30,95,168,0.3));
        }
        .product-card:hover .card-badge {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .product-card:hover .card-arrow {
            transform: translateX(6px);
            opacity: 1;
        }
        .card-icon {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .card-badge {
            transition: all 0.3s ease;
        }
        .card-arrow {
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        /* CARTES AVANTAGES — Glass effect */
        .advantage-card {
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .advantage-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            background: rgba(255,255,255,0.9);
        }
        .advantage-card:hover .adv-icon {
            transform: scale(1.1);
        }
        .adv-icon {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* ANIMATIONS */
        .section-hidden { opacity: 0; transform: translateY(40px); transition: all 0.8s ease; }
        .section-visible { opacity: 1; transform: translateY(0); }

        /* DÉGRADÉ CONTINU — de "Pourquoi Karibu" au footer */
        .gradient-continuous {
            background: linear-gradient(180deg, #f9fafb 0%, #eef4fb 8%, #d4e4f7 18%, #a9c9ef 30%, #7eafe7 42%, #5394df 55%, #2879d7 68%, #1e5fa8 78%, #174882 88%, #10325c 95%, #0a1d38 100%);
        }
    </style>
</head>
<body class="bg-white text-gray-900 overflow-x-hidden" x-data="{ mobileMenu: false, scrolled: false }"
      @scroll.window="scrolled = (window.scrollY > 50)">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-white/20"
         :class="scrolled ? 'nav-scrolled py-3' : 'bg-transparent py-5'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-royal-600 to-royal-400 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-black text-2xl">K</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-xl tracking-tight" :class="scrolled ? 'text-gray-900' : 'text-white'">KARIBU</span>
                    <span class="text-[10px] font-semibold tracking-[0.25em] uppercase" :class="scrolled ? 'text-gray-400' : 'text-white/50'">TECHNOLOGIES</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#produits" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-royal-600' : 'text-white/80 hover:text-white'">Produits</a>
                <a href="#avantages" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-royal-600' : 'text-white/80 hover:text-white'">Avantages</a>
                <a href="#pricing" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-royal-600' : 'text-white/80 hover:text-white'">Tarifs</a>
                <a href="#contact" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-royal-600' : 'text-white/80 hover:text-white'">Contact</a>
                <a href="{{ route('login') }}" class="btn-primary text-white px-6 py-2.5 rounded-xl font-semibold">Connexion</a>
            </div>
            <button @click="mobileMenu = !mobileMenu" class="md:hidden" :class="scrolled ? 'text-gray-900' : 'text-white'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div x-show="mobileMenu" x-transition class="md:hidden bg-white rounded-b-2xl shadow-xl mx-4 mt-2 p-4">
            <a href="#produits" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Produits</a>
            <a href="#avantages" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Avantages</a>
            <a href="#pricing" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Tarifs</a>
            <a href="#contact" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">Contact</a>
            <a href="{{ route('login') }}" class="block mt-2 btn-primary text-white text-center px-6 py-3 rounded-xl font-semibold">Connexion</a>
        </div>
    </nav>

    <!-- ═══════════════════════════════════════ HERO ═══════════════════════════════════════ -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-royal-950 via-royal-900 to-royal-800">
        <div class="filigrane"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="fade-in-up" style="animation-delay: 0.2s;">
                <span class="inline-block bg-white/10 backdrop-blur-sm text-white/90 text-sm font-medium px-4 py-2 rounded-full mb-6 border border-white/20">
                    Made in Côte d’Ivoire
                </span>
            </div>
            <h1 class="fade-in-up text-5xl md:text-7xl font-black text-white mb-6 leading-tight" style="animation-delay: 0.4s;">
                La technologie<br>
                <span class="gradient-text">au service</span><br>
                de votre business
            </h1>
            <p class="fade-in-up text-xl md:text-2xl text-white/70 mb-10 max-w-2xl mx-auto" style="animation-delay: 0.6s;">
                Suite logicielle SaaS pour entreprises ivoiriennes. Paie, Scolaire, VTC — conforme aux normes locales.
            </p>
            <div class="fade-in-up flex flex-col sm:flex-row gap-4 justify-center" style="animation-delay: 0.8s;">
                <a href="#produits" class="btn-primary text-white px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center justify-center gap-2">
                    Découvrir nos solutions
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="#contact" class="btn-outline px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center justify-center gap-2">
                    Nous contacter
                </a>
            </div>
            <div class="fade-in-up mt-20 grid grid-cols-3 gap-8 max-w-lg mx-auto" style="animation-delay: 1s;">
                <div>
                    <div class="text-3xl font-black text-white">3</div>
                    <div class="text-sm text-white/50 mt-1">Solutions SaaS</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">100%</div>
                    <div class="text-sm text-white/50 mt-1">Made in CI</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white">24/7</div>
                    <div class="text-sm text-white/50 mt-1">Disponible</div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </div>
    </section>

    <!-- ═══════════════════════════════════════ NOS PRODUITS ═══════════════════════════════════════ -->
    <section id="produits" class="py-24 bg-gray-50 relative">
        <div class="filigrane-light"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-royal-600 font-semibold text-sm uppercase tracking-wider">Nos Produits</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3 mb-4">Solutions mariées à vos besoins</h2>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto">Chaque produit est conçu pour un métier spécifique, avec les normes locales intégrées.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- KARIBU VTC -->
                <div class="product-card" style="--card-color: #1e5fa8; --card-glow: rgba(30,95,168,0.06); --card-shadow: rgba(30,95,168,0.15);">
                    <div class="card-icon w-16 h-16 bg-gradient-to-br from-royal-600 to-royal-400 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <span class="card-badge inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full mb-4">EN COURS DE DÉVELOPPEMENT</span>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Karibu VTC</h3>
                    <p class="text-gray-500 mb-6 leading-relaxed">Gestion de flotte VTC, réservations clients, suivi temps réel, facturation automatique et conformité réglementaire.</p>
                    <a href="https://karibu.co.ci" class="inline-flex items-center gap-2 text-royal-600 font-semibold hover:text-royal-800 transition-colors">
                        En savoir plus
                        <svg class="w-4 h-4 card-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- KARIBU PAIE -->
                <div class="product-card" style="--card-color: #059669; --card-glow: rgba(5,150,105,0.06); --card-shadow: rgba(5,150,105,0.15);">
                    <div class="card-icon w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="card-badge inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full mb-4">EN COURS DE DÉVELOPPEMENT</span>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Karibu Paie</h3>
                    <p class="text-gray-500 mb-6 leading-relaxed">Gestion de paie complète avec CNPS, ITS, bulletin de paie PDF, déclarations sociales et conformité ivoirienne.</p>
                    <span class="inline-flex items-center gap-2 text-royal-600 font-semibold">
                        À partir de 20 000 FCFA/mois
                    </span>
                </div>

                <!-- KARIBU SCOLAIRE -->
                <div class="product-card" style="--card-color: #7c3aed; --card-glow: rgba(124,58,237,0.06); --card-shadow: rgba(124,58,237,0.15);">
                    <div class="card-icon w-16 h-16 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="card-badge inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-4">BIENTÔT DISPONIBLE</span>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Karibu Scolaire</h3>
                    <p class="text-gray-500 mb-6 leading-relaxed">Gestion scolaire complète, notes, emplois du temps, parents d’élèves, bulletins, comptabilité et pédagogie intégrée.</p>
                    <span class="inline-flex items-center gap-2 text-royal-600 font-semibold">
                        À partir de 15 000 FCFA/mois
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════ AVANTAGES + TARIFICATION + CONTACT + FOOTER = DÉGRADÉ CONTINU ═══════════════════════════════════════ -->
    <div class="gradient-continuous">

        <!-- AVANTAGES -->
        <section id="avantages" class="py-24 relative">
            <div class="filigrane-light"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-royal-600 font-semibold text-sm uppercase tracking-wider">Pourquoi Karibu</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3 mb-4">Conçu pour l’Afrique de l’Ouest</h2>
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto">Nous comprenons les réalités locales. Nos solutions sont pensées pour vos défis.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-royal-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-royal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">Conforme CNPS & ITS</h4>
                        <p class="text-gray-500 text-sm">Taux calculés automatiquement, déclarations pré-remplies.</p>
                    </div>
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">Prix en FCFA</h4>
                        <p class="text-gray-500 text-sm">Pas de frais cachés. Tout est intégré. Paiement mobile Money.</p>
                    </div>
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">SaaS Cloud</h4>
                        <p class="text-gray-500 text-sm">Accessible partout, tout le temps. Pas d’installation.</p>
                    </div>
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">Rapide & Simple</h4>
                        <p class="text-gray-500 text-sm">Interface intuitive. Aucune formation requise.</p>
                    </div>
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">Sécurisé</h4>
                        <p class="text-gray-500 text-sm">Données cryptées, sauvegardes automatiques, conforme RGPD.</p>
                    </div>
                    <div class="advantage-card">
                        <div class="adv-icon w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">Support local</h4>
                        <p class="text-gray-500 text-sm">Équipe basée en Côte d’Ivoire. Réponse rapide.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- TARIFICATION -->
        <section id="pricing" class="py-24 relative">
            <div class="filigrane-light"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-royal-600 font-semibold text-sm uppercase tracking-wider">Tarification</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3 mb-4">Des prix adaptés à votre budget</h2>
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto">Commencez grâtuitement. Passez au niveau supérieur quand vous êtes prêt.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <!-- Essentiel -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Essentiel</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-4xl font-black text-gray-900">20 000</span>
                            <span class="text-gray-400">FCFA/mois</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-6">Jusqu’à 15 salariés</p>
                        <a href="{{ route('checkout.index') }}?plan=essentiel" class="block w-full border-2 border-royal-600 text-royal-600 text-center py-3 rounded-xl font-semibold mb-8 hover:bg-royal-600 hover:text-white transition-all">Commencer</a>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Calcul CNPS & ITS</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Bulletin de paie PDF</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>1 utilisateur</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Support par email</li>
                        </ul>
                    </div>
                    <!-- Pro -->
                    <div class="bg-gradient-to-br from-royal-600 to-royal-800 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl scale-105">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="text-sm font-semibold text-white/60 uppercase tracking-wider mb-2">Professionnel</div>
                            <div class="flex items-baseline gap-1 mb-2">
                                <span class="text-4xl font-black">35 000</span>
                                <span class="text-white/60">FCFA/mois</span>
                            </div>
                            <p class="text-white/60 text-sm mb-6">Jusqu’à 50 salariés</p>
                            <a href="{{ route('checkout.index') }}?plan=professionnel" class="block w-full bg-white text-royal-700 text-center py-3 rounded-xl font-bold hover:bg-white/90 transition mb-8">Commencer</a>
                            <ul class="space-y-3">
                                <li class="flex items-center gap-3 text-white/80 text-sm"><svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Tout dans Essentiel</li>
                                <li class="flex items-center gap-3 text-white/80 text-sm"><svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Multi-utilisateurs</li>
                                <li class="flex items-center gap-3 text-white/80 text-sm"><svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Exports comptables</li>
                                <li class="flex items-center gap-3 text-white/80 text-sm"><svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Support prioritaire</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Enterprise -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Enterprise</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-4xl font-black text-gray-900">Sur mesure</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-6">Sans limite</p>
                        <a href="#contact" class="block w-full border-2 border-royal-600 text-royal-600 text-center py-3 rounded-xl font-semibold mb-8 hover:bg-royal-600 hover:text-white transition-all">Nous contacter</a>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Tout dans Pro</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>API & intégrations</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Deployment on-premise</li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Support dédié 24/7</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('pricing') }}" class="text-royal-600 font-semibold hover:text-royal-800 transition">Voir tous les tarifs &rarr;</a>
                    <span class="mx-4 text-gray-300">|</span>
                    <a href="{{ route('demo.index') }}" class="text-royal-600 font-semibold hover:text-royal-800 transition">Réserver une démo</a>
                </div>
            </div>
        </section>

        <!-- CONTACT -->
        <section id="contact" class="py-24 relative">
            <div class="filigrane"></div>
            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Prêt à démarrer ?</h2>
                <p class="text-xl text-white/70 mb-10 max-w-2xl mx-auto">Rejoignez les entreprises ivoiriennes qui font confiance à Karibu Technologies.</p>
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-white/20">
                    <div class="grid md:grid-cols-2 gap-8 text-left">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">Contactez-nous</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-white/80">contact@karibu.co.ci</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <span class="text-white/80">+225 XX XX XX XX XX</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <span class="text-white/80">Abidjan, Côte d’Ivoire</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">Envoyez-nous un message</h3>
                            <form class="space-y-4">
                                <input type="text" placeholder="Votre nom" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:border-white/40">
                                <input type="email" placeholder="Votre email" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:border-white/40">
                                <textarea rows="3" placeholder="Votre message" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:border-white/40 resize-none"></textarea>
                                <button type="submit" class="w-full bg-white text-royal-700 py-3 rounded-xl font-bold hover:bg-white/90 transition">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="py-12 relative">
            <div class="filigrane"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <span class="text-white font-black text-lg">K</span>
                        </div>
                        <div class="flex flex-col leading-none">
                            <span class="font-black text-lg text-white">KARIBU</span>
                            <span class="text-[9px] font-semibold tracking-[0.25em] text-white/50">TECHNOLOGIES</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-8">
                        <a href="#produits" class="text-white/60 hover:text-white transition text-sm">Produits</a>
                        <a href="#pricing" class="text-white/60 hover:text-white transition text-sm">Tarifs</a>
                        <a href="#contact" class="text-white/60 hover:text-white transition text-sm">Contact</a>
                        <a href="{{ route('login') }}" class="text-white/60 hover:text-white transition text-sm">Connexion</a>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-8 pt-8 text-center">
                    <p class="text-white/40 text-sm">&copy; {{ date('Y') }} Karibu Technologies. Tous droits réservés.</p>
                    <p class="mt-1 text-xs text-white/25">Fait avec passion en Côte d’Ivoire</p>
                </div>
            </div>
        </footer>
    </div><!-- /gradient-continuous -->

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('section-visible');
                        entry.target.classList.remove('section-hidden');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('section > .relative.z-10').forEach(el => {
                el.classList.add('section-hidden');
                observer.observe(el);
            });
        });
    </script>
</body>
</html>