<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Karibu Technologies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { royal: { 600: '#1e5fa8', 700: '#174882' } } } } }
    </script>
    <style>* { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center max-w-md mx-auto px-4">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-2xl font-black text-gray-900 mb-3">{{ $title }}</h1>
        <p class="text-gray-500 mb-8">{{ $message }}</p>
        <a href="/" class="inline-block bg-royal-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-royal-700 transition">Retour à l'accueil</a>
    </div>
</body>
</html>
