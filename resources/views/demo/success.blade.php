<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e5fa8">
    <title>Demande envoyée — Karibu Paie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { royal: { 50:'#eef4fb',100:'#d4e4f7',200:'#a9c9ef',300:'#7eafe7',400:'#5394df',500:'#2879d7',600:'#1e5fa8',700:'#174882',800:'#10325c',900:'#0a1d38',950:'#060f1f' } } } }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto text-center px-4 py-16">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Demande envoyée !</h1>
        <p class="text-gray-500 mb-8">Merci pour votre intérêt. Notre équipe vous contactera sous 24h pour confirmer votre créneau de démo.</p>
        <a href="{{ route('landing') }}" class="inline-block bg-royal-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-royal-700 transition">Retour à l'accueil</a>
    </div>
</body>
</html>
