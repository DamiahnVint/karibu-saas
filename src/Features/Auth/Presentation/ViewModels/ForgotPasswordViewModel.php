<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\ViewModels;

use Illuminate\Contracts\Support\Arrayable;

final class ForgotPasswordViewModel implements Arrayable
{
    public function __construct(
        public string $appName = 'Karibu',
        public ?string $status = null,
        public ?string $error = null,
    ) {}

    public static function make(?string $status = null, ?string $error = null): self
    {
        return new self(status: $status, error: $error);
    }

    public function toArray(): array
    {
        return [
            'appName' => $this->appName,
            'status' => $this->status,
            'error' => $this->error,
        ];
    }
}
