<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\Http;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Features\Auth\Application\ResetPasswordAction;
use Src\Features\Auth\Presentation\Requests\ResetPasswordRequest;

final class ResetPasswordController extends Controller
{
    public function showForm(string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->input('email'),
        ]);
    }

    public function reset(ResetPasswordRequest $request, ResetPasswordAction $action): RedirectResponse
    {
        $result = $action->execute($request->validated());

        if ($result['success']) {
            return redirect()->route('login')
                ->with('success', 'Mot de passe réinitialisé avec succès.');
        }

        return back()->withErrors(['email' => $result['message']]);
    }
}
