<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $userRole = Role::from($user->role);

        foreach ($roles as $roleName) {
            $requiredRole = Role::from($roleName);
            if ($userRole->canManage($requiredRole) || $userRole === $requiredRole) {
                return $next($request);
            }
        }

        abort(403, 'Vous n\'avez pas les permissions nécessaires pour accéder à cette ressource.');
    }
}
