<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e5fa8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Karibu Paie">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/icons/favicon.png">
    <title>{{ $title ?? 'Dashboard' }} — Karibu Paie</title>
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
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.625rem 0.75rem; border-radius: 0.75rem;
            font-size: 0.875rem; font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar-link-active {
            background-color: #1e5fa8; color: #fff;
            box-shadow: 0 10px 15px -3px rgba(30, 95, 168, 0.25);
        }
        .sidebar-link-default { color: #4b5563; }
        .sidebar-link-default:hover {
            background-color: #f3f4f6; color: #111827;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false, sidebarDesktop: true }">
    {{-- SIDEBAR MOBILE OVERLAY --}}
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="sidebarOpen = false"></div>

    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transform transition-transform duration-300 lg:translate-x-0 flex flex-col"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-gray-100 flex-shrink-0">
            <div class="w-9 h-9 bg-royal-600 rounded-xl flex items-center justify-center">
                <span class="text-white font-black text-lg">K</span>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-black text-base text-gray-900">KARIBU</span>
                <span class="text-[9px] font-semibold tracking-[0.2em] text-gray-400">PAIE</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-6">
            {{-- Principal --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">Principal</div>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/></svg>
                    Dashboard
                </a>
            </div>

            {{-- CMS (super_admin only) --}}
            @if(auth()->user()->role === 'super_admin')
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">CMS</div>
                <a href="{{ route('admin.cms.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.cms.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    CMS
                </a>
                <a href="{{ route('admin.cms.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.pages.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pages
                </a>
                <a href="{{ route('admin.cms.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.settings.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Paramètres
                </a>
                <a href="{{ route('admin.cms.navigation.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.navigation.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Navigation
                </a>
                <a href="{{ route('admin.cms.media.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.media.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Médias
                </a>
                <a href="{{ route('admin.cms.forms.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.forms.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Formulaires
                </a>
            </div>

            {{-- Gestion SaaS --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">Gestion SaaS</div>
                <a href="{{ route('admin.plans.index') }}" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Plans & Tarifs
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="sidebar-link {{ request()->routeIs('admin.tenants.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tenants
                </a>
            </div>
            @endif

            {{-- Module Paie (tous les rôles) --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">Module</div>
                <div class="sidebar-link sidebar-link-default opacity-50 cursor-not-allowed">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Paie</span>
                    <span class="ml-auto text-[10px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Bientôt</span>
                </div>
            </div>
        </nav>

        {{-- User footer --}}
        <div class="border-t border-gray-100 px-4 py-4 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-royal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-royal-700 font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-gray-400">{{ \App\Enums\Role::tryFrom(auth()->user()->role)?->label() ?? auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Déconnexion">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="lg:pl-72 min-h-screen flex flex-col">
        {{-- Top bar mobile --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-200 lg:hidden">
            <div class="flex items-center justify-between h-14 px-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-royal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-black text-xs">K</span>
                    </div>
                    <span class="font-bold text-sm text-gray-900">Karibu Paie</span>
                </div>
                <div class="w-9"></div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
</body>
</html>
