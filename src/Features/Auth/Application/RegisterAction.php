<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application;

use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use Src\Features\Auth\Application\DTOs\RegisterDTO;
use Src\Features\Auth\Application\DTOs\UserDTO;
use Src\Features\Auth\Domain\Contracts\UserRepositoryInterface;
use Src\Features\Auth\Domain\Events\UserRegistered;
use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * Use Case : Inscription utilisateur.
 *
 * Le premier utilisateur créé est automatiquement TENANT_OWNER.
 * Les utilisateurs suivants sont TENANT_USER par défaut.
 */
final class RegisterAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @return array{success: bool, message: string, user?: UserDTO}
     */
    public function execute(RegisterDTO $dto): array
    {
        if ($this->userRepository->emailExists($dto->email)) {
            return [
                'success' => false,
                'message' => 'Cette adresse email est déjà utilisée.',
            ];
        }

        $user = $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email->value(),
            'password' => Hash::make($dto->password),
            'role' => Role::TENANT_USER->value,
            'phone' => $dto->phone,
            'is_active' => true,
        ]);

        return [
            'success' => true,
            'message' => 'Compte créé avec succès.',
            'user' => UserDTO::fromArray($user),
        ];
    }
}
