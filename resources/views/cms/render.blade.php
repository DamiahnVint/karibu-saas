<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="{{ $settings['site_color'] ?? '#1e5fa8' }}">
    <meta name="description" content="{{ $pageData['meta_description'] ?? $settings['site_description'] ?? '' }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $settings['site_name'] ?? 'Karibu' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/icons/favicon.png">
    <title>{{ $pageData['meta_title'] ?? $pageData['title'] ?? $settings['site_name'] ?? 'Karibu' }}</title>
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
        .gradient-text { background: linear-gradient(135deg, #93c5fd, #67e8f9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .filigrane {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url('/images/code-engineering.jpg');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.33; mix-blend-mode: multiply;
        }
        .filigrane-light {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url('/images/code-engineering.jpg');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.25; mix-blend-mode: multiply;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e5fa8, #174882);
            transition: all 0.3s ease;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(30,95,168,0.3); }
        .section-hidden { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .section-visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-white">
    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-white/20"
         x-data="{ mobileMenu: false, scrolled: false }"
         @scroll.window="scrolled = (window.scrollY > 50)"
         :class="scrolled ? 'bg-white/95 backdrop-blur-xl shadow-lg border-b border-gray-100 py-3' : 'bg-transparent py-5'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-royal-600 to-royal-400 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-black text-2xl">K</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-xl tracking-tight" :class="scrolled ? 'text-gray-900' : 'text-white'">KARIBU</span>
                    <span class="text-[10px] font-semibold tracking-[0.25em] uppercase" :class="scrolled ? 'text-gray-400' : 'text-white/50'">TECHNOLOGIES</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8">
                @foreach($navigation['header'] ?? [] as $item)
                    <a href="{{ $item['url'] }}" class="font-medium transition-colors" :class="scrolled ? 'text-gray-600 hover:text-royal-600' : 'text-white/80 hover:text-white'">{{ $item['label'] }}</a>
                @endforeach
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
            @foreach($navigation['mobile'] ?? $navigation['header'] ?? [] as $item)
                <a href="{{ $item['url'] }}" @click="mobileMenu = false" class="block py-3 px-4 text-gray-700 hover:bg-blue-50 rounded-xl">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('login') }}" class="block mt-2 btn-primary text-white text-center px-6 py-3 rounded-xl font-semibold">Connexion</a>
        </div>
    </nav>

    {{-- SECTIONS --}}
    @foreach($pageData['sections'] as $section)
        @include('cms.sections.' . $section['type'], ['section' => $section, 'settings' => $settings])
    @endforeach

    {{-- FOOTER --}}
    <footer class="py-12 relative bg-gray-900">
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
                <div class="flex gap-6">
                    @foreach($navigation['footer'] ?? [] as $item)
                        <a href="{{ $item['url'] }}" class="text-white/60 hover:text-white transition text-sm">{{ $item['label'] }}</a>
                    @endforeach
                </div>
                <div class="text-white/40 text-sm">&copy; {{ date('Y') }} Karibu Technologies. Tous droits réservés.</div>
            </div>
        </div>
    </footer>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('section-visible');
                    entry.target.classList.remove('section-hidden');
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('section').forEach(s => { s.classList.add('section-hidden'); observer.observe(s); });
    </script>
</body>
</html>
