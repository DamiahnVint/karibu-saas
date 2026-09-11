<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
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

        /* Page entrance animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out both;
        }

        /* Sidebar */
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.5625rem 0.75rem; border-radius: 0.625rem;
            font-size: 0.8125rem; font-weight: 500;
            transition: all 0.15s ease;
            color: rgba(255,255,255,0.55);
            position: relative;
        }
        .sidebar-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.95);
        }
        .sidebar-link-active {
            background: linear-gradient(135deg, rgba(30,95,168,0.5), rgba(30,95,168,0.3));
            color: #fff !important;
            box-shadow: 0 0 20px rgba(30,95,168,0.3), inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .sidebar-link-active::before {
            content: '';
            position: absolute;
            left: -1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #5394df, #1e5fa8);
            border-radius: 0 4px 4px 0;
        }

        /* Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Topbar blur */
        .topbar-blur {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
        }

        /* Glow on hover for cards */
        .glow-hover {
            transition: all 0.2s ease;
        }
        .glow-hover:hover {
            box-shadow: 0 0 0 1px rgba(30,95,168,0.15), 0 8px 25px -5px rgba(30,95,168,0.12);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50/80" x-data="{ sidebarOpen: false, sidebarDesktop: true }">
    {{-- SIDEBAR MOBILE OVERLAY --}}
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-[260px] bg-gradient-to-b from-gray-950 via-gray-950 to-royal-950 transform transition-transform duration-300 lg:translate-x-0 flex flex-col"
    >
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 flex-shrink-0 border-b border-white/5">
            <div class="w-9 h-9 bg-gradient-to-br from-royal-400 to-royal-600 rounded-xl flex items-center justify-center shadow-lg shadow-royal-600/30">
                <span class="text-white font-black text-lg">K</span>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-black text-[15px] text-white tracking-tight">KARIBU</span>
                <span class="text-[9px] font-semibold tracking-[0.25em] text-royal-400">PAIE</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4 space-y-5">
            {{-- Principal --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-white/25">Principal</div>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/></svg>
                    Dashboard
                </a>
            </div>

            {{-- CMS (super_admin only) --}}
            @if(auth()->user()->role === 'super_admin')
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-white/25">CMS</div>
                <a href="{{ route('admin.cms.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.cms.dashboard') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    CMS
                </a>
                <a href="{{ route('admin.cms.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.pages.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pages
                </a>
                <a href="{{ route('admin.cms.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.settings.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Paramètres
                </a>
                <a href="{{ route('admin.cms.navigation.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.navigation.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Navigation
                </a>
                <a href="{{ route('admin.cms.media.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.media.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Médias
                </a>
                <a href="{{ route('admin.cms.forms.index') }}" class="sidebar-link {{ request()->routeIs('admin.cms.forms.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Formulaires
                </a>
            </div>

            {{-- Gestion SaaS --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-white/25">Gestion SaaS</div>
                <a href="{{ route('admin.plans.index') }}" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Plans & Tarifs
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="sidebar-link {{ request()->routeIs('admin.tenants.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tenants
                </a>
            </div>
            @endif

            {{-- Module Paie --}}
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-white/25">Module</div>
                <a href="{{ route('paie.dashboard') }}" class="sidebar-link {{ request()->routeIs('paie.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Paie</span>
                </a>
                <a href="{{ route('paie.employees.index') }}" class="sidebar-link {{ request()->routeIs('paie.employees.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    <span>Employés</span>
                </a>
                <a href="{{ route('paie.payslips.index') }}" class="sidebar-link {{ request()->routeIs('paie.payslips.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span>Bulletins</span>
                </a>
                <a href="{{ route('paie.leaves.index') }}" class="sidebar-link {{ request()->routeIs('paie.leaves.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Congés</span>
                </a>
                <a href="{{ route('paie.declarations.index') }}" class="sidebar-link {{ request()->routeIs('paie.declarations.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Déclarations</span>
                </a>
            </div>
        </nav>

        {{-- User footer --}}
        <div class="border-t border-white/5 px-3 py-3 flex-shrink-0">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/5 transition-colors cursor-default">
                <div class="w-8 h-8 bg-gradient-to-br from-royal-400 to-royal-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                    <span class="text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-white/90 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-white/40">{{ \App\Enums\Role::tryFrom(auth()->user()->role)?->label() ?? auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 text-white/30 hover:text-rose-400 hover:bg-rose-400/10 rounded-lg transition" title="Déconnexion">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="lg:pl-[260px] min-h-screen flex flex-col">
        {{-- Top bar mobile --}}
        <header class="sticky top-0 z-30 bg-white/80 topbar-blur border-b border-gray-200/60 lg:hidden">
            <div class="flex items-center justify-between h-14 px-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-gradient-to-br from-royal-400 to-royal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-black text-xs">K</span>
                    </div>
                    <span class="font-bold text-sm text-gray-900">Karibu Paie</span>
                </div>
                <div class="w-9"></div>
            </div>
        </header>

        {{-- Desktop topbar --}}
        <header class="sticky top-0 z-30 bg-white/80 topbar-blur border-b border-gray-200/60 hidden lg:block">
            <div class="flex items-center justify-between h-14 px-8">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">Karibu Paie</span>
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-semibold text-gray-700">{{ $title ?? 'Dashboard' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 p-6 lg:p-8 animate-fade-in-up">
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
