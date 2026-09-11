<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application;

use Illuminate\Support\Facades\Auth;

/**
 * Use Case : Déconnexion.
 */
final class LogoutAction
{
    /**
     * @return array{success: bool, message: string}
     */
    public function execute(): array
    {
        Auth::logout();

        return [
            'success' => true,
            'message' => 'Déconnexion réussie.',
        ];
    }
}
