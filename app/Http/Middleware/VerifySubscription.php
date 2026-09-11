<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->route('onboarding.index')->with('info', 'Bienvenue ! Configurez votre entreprise.');
        }

        if (!$tenant->is_active) {
            return redirect()->route('subscription.blocked')
                ->with('error', 'Votre compte a été désactivé. Contactez le support.');
        }

        if ($tenant->hasAccess()) {
            return $next($request);
        }

        return redirect()->route('subscription.expired')
            ->with('error', 'Votre abonnement a expiré. Veuillez renouveler pour continuer.');
    }
}
