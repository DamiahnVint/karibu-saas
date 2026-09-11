<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Features\Auth\Application\ForgotPasswordAction;
use Src\Features\Auth\Presentation\Requests\ForgotPasswordRequest;
use Src\Features\Auth\Presentation\ViewModels\ForgotPasswordViewModel;
use Src\Features\Common\Domain\ValueObjects\Email;

final class ForgotPasswordController extends Controller
{
    public function showForm(): View
    {
        return view('auth.forgot-password', ForgotPasswordViewModel::make()->toArray());
    }

    public function sendResetLink(ForgotPasswordRequest $request, ForgotPasswordAction $action): RedirectResponse
    {
        $email = Email::fromString($request->input('email'));

        $result = $action->execute($email);

        return back()->withErrors([
            'email' => $result['message'],
        ])->with('status', $result['message']);
    }
}
