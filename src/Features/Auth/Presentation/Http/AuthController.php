<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Src\Features\Auth\Application\LoginAction;
use Src\Features\Auth\Application\DTOs\LoginDTO;
use Src\Features\Auth\Presentation\Requests\LoginRequest;
use Src\Features\Auth\Presentation\ViewModels\LoginViewModel;
use Illuminate\View\View;

/**
 * Contrôleur Auth — Thin Controller.
 *
 * Responsabilités :
 * - Valider la requête (FormRequest)
 * - Convertir en DTO
 * - Appeler le Use Case (LoginAction)
 * - Retourner la réponse (Vue ou Redirect)
 *
 * Aucune logique métier ici.
 */
final class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        return view('auth.login', LoginViewModel::make()->toArray());
    }

    public function login(LoginRequest $request, LoginAction $loginAction): RedirectResponse
    {
        $dto = LoginDTO::fromArray($request->validated());

        $result = $loginAction->execute($dto);

        if (!$result['success']) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => $result['message']]);
        }

        $request->session()->regenerate();

        return $this->redirectAfterLogin($result['user']);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('landing');
    }

    private function redirectAfterLogin(mixed $user): RedirectResponse
    {
        if ($user instanceof \Src\Features\Auth\Application\DTOs\UserDTO) {
            if ($user->role === 'super_admin') {
                return redirect()->route('dashboard');
            }
            if ($user->tenantId) {
                $tenant = \App\Models\Tenant::find($user->tenantId);
                if ($tenant) {
                    return redirect()->route('tenant.dashboard', $tenant->slug);
                }
            }
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard');
    }
}
