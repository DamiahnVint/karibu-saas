<x-layouts.guest title="Nouveau mot de passe" :header="'Définissez votre nouveau mot de passe'">
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-ui.input
            name="email"
            label="Adresse email"
            type="email"
            :value="$email ?? ''"
            :required="true"
            :error="$errors->first('email')"
        />

        <x-ui.input
            name="password"
            label="Nouveau mot de passe"
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
            Réinitialiser le mot de passe
        </x-ui.button>
    </form>
</x-layouts.guest>
