<x-layouts.guest title="Inscription" :header="'Créez votre compte'">
    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ loading: false }" x-on:submit="loading = true">
        @csrf

        <x-ui.input
            name="name"
            label="Nom complet"
            placeholder="Votre nom"
            :required="true"
            :error="$errors->first('name')"
        />

        <x-ui.input
            name="email"
            label="Adresse email"
            type="email"
            placeholder="vous@entreprise.com"
            :required="true"
            :error="$errors->first('email')"
        />

        <x-ui.input
            name="phone"
            label="Téléphone"
            type="tel"
            placeholder="+225 XX XX XX XX XX"
            :error="$errors->first('phone')"
        />

        <x-ui.input
            name="password"
            label="Mot de passe"
            type="password"
            placeholder="8 caractères minimum"
            :required="true"
            :error="$errors->first('password')"
        />

        <x-ui.input
            name="password_confirmation"
            label="Confirmer le mot de passe"
            type="password"
            placeholder="Retapez votre mot de passe"
            :required="true"
        />

        <x-ui.button type="submit" class="w-full">
            <span x-show="!loading">Créer mon compte</span>
            <span x-show="loading" x-cloak>Création...</span>
        </x-ui.button>

        <p class="text-center text-sm text-gray-600">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-royal-600 hover:text-royal-500 font-medium">
                Se connecter
            </a>
        </p>
    </form>
</x-layouts.guest>
