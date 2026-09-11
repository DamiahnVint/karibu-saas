<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Src\Features\Auth\Application\DTOs\LoginDTO;
use Src\Features\Auth\Application\DTOs\UserDTO;
use Src\Features\Auth\Domain\Contracts\UserRepositoryInterface;
use Src\Features\Auth\Domain\Rules\IsActiveUser;

/**
 * Use Case : Connexion utilisateur.
 *
 * Responsabilités :
 * - Rechercher l'utilisateur par email
 * - Vérifier le mot de passe
 * - Vérifier que le compte est actif (règle métier Domain)
 * - Authentifier via Laravel session
 * - Enregistrer la date de dernière connexion
 * - Retourner un UserDTO (pas un modèle Eloquent)
 */
final class LoginAction
{
    private IsActiveUser $isActiveUser;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
        $this->isActiveUser = new IsActiveUser();
    }

    /**
     * @return array{success: bool, message: string, user?: UserDTO}
     */
    public function execute(LoginDTO $dto): array
    {
        $userData = $this->userRepository->findByEmail($dto->email);

        if (!$userData) {
            return [
                'success' => false,
                'message' => 'Email ou mot de passe incorrect.',
            ];
        }

        if (!Hash::check($dto->password, $userData['password'])) {
            return [
                'success' => false,
                'message' => 'Email ou mot de passe incorrect.',
            ];
        }

        $access = $this->isActiveUser->check($userData);

        if (!$access['allowed']) {
            return [
                'success' => false,
                'message' => $access['reason'],
            ];
        }

        Auth::loginUsingId($userData['id'], $dto->remember);

        $this->userRepository->updateLastLogin($userData['id']);

        return [
            'success' => true,
            'message' => 'Connexion réussie.',
            'user' => UserDTO::fromArray($userData),
        ];
    }
}
