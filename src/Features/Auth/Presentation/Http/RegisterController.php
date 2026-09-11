<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Features\Auth\Application\RegisterAction;
use Src\Features\Auth\Application\DTOs\RegisterDTO;
use Src\Features\Auth\Presentation\Requests\RegisterRequest;
use Src\Features\Auth\Presentation\ViewModels\RegisterViewModel;

final class RegisterController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register', RegisterViewModel::make()->toArray());
    }

    public function register(RegisterRequest $request, RegisterAction $registerAction): RedirectResponse
    {
        $dto = RegisterDTO::fromArray($request->validated());

        $result = $registerAction->execute($dto);

        if (!$result['success']) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => $result['message']]);
        }

        return redirect()->route('login')
            ->with('success', 'Compte créé avec succès. Connectez-vous.');
    }
}
