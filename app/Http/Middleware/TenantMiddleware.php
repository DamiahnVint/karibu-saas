<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de résolution tenant.
 *
 * Responsabilités :
 * - Vérifier que l'utilisateur est authentifié
 * - Vérifier qu'il a un tenant associé
 * - Charger le tenant et vérifier qu'il est actif
 * - Injecter le tenant dans la request et le container
 *
 * Ce middleware NE DOIT PAS gérer la redirection login.
 * La gestion auth est dans les routes (middleware 'auth').
 */
class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Authentification requise.');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (!$user->tenant_id) {
            abort(403, 'Aucun tenant associé à cet utilisateur.');
        }

        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant) {
            abort(404, 'Tenant introuvable.');
        }

        if (!$tenant->isActive()) {
            abort(403, 'Votre abonnement a expiré ou votre compte est désactivé.');
        }

        app()->instance('current_tenant', $tenant);

        $request->merge(['tenant' => $tenant]);

        return $next($request);
    }
}
