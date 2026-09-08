<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karibu Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">K</span>
                </div>
                <span class="font-bold text-lg">Karibu</span>
            </div>
            <nav class="space-y-2">
                <a href="#" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-semibold text-sm">Tableau de bord</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm">Employes</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm">Bulletins de paie</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm">Declarations</a>
                <a href="#" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm">Parametres</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold">Bonjour, {{ $user->name }}</h1>
                    <p class="text-gray-500">{{ $tenant->name ?? 'Karibu Software' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 text-sm font-medium">Deconnexion</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Employes</div>
                    <div class="text-3xl font-black text-blue-600">0</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Bulletins ce mois</div>
                    <div class="text-3xl font-black text-green-600">0</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="text-sm text-gray-500 mb-1">Masse salariale</div>
                    <div class="text-3xl font-black text-purple-600">0 FCFA</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-4">Bienvenue sur Karibu Paie</h2>
                <p class="text-gray-500">Votre tableau de bord sera bientot disponible. En cours de configuration.</p>
            </div>
        </main>
    </div>
</body>
</html>
