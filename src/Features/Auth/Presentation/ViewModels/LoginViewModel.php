<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\ViewModels;

use Illuminate\Contracts\Support\Arrayable;

/**
 * ViewModel pour la page de connexion.
 * Les Blade templates reçoivent ce ViewModel converti en array.
 */
final class LoginViewModel implements Arrayable
{
    public function __construct(
        public string $appName = 'Karibu',
        public string $tagline = 'Gestion de paie simplifiée',
        public ?string $error = null,
        public array $old = [],
    ) {}

    public static function make(?string $error = null, array $old = []): self
    {
        return new self(error: $error, old: $old);
    }

    public function toArray(): array
    {
        return [
            'appName' => $this->appName,
            'tagline' => $this->tagline,
            'error' => $this->error,
            'old' => $this->old,
        ];
    }
}
