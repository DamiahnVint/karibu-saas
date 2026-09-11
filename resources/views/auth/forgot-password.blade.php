<x-layouts.guest title="Mot de passe oublié" :header="'Réinitialisez votre mot de passe'">
    <p class="text-sm text-gray-600 mb-6">
        Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-ui.input
            name="email"
            label="Adresse email"
            type="email"
            placeholder="vous@entreprise.com"
            :required="true"
            :error="$errors->first('email')"
        />

        <x-ui.button type="submit" class="w-full">
            Envoyer le lien
        </x-ui.button>

        <p class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-royal-600 hover:text-royal-500 font-medium">
                &larr; Retour à la connexion
            </a>
        </p>
    </form>
</x-layouts.guest>
