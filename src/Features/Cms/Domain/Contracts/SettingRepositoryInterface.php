<?php

namespace Src\Features\Cms\Domain\Contracts;

interface SettingRepositoryInterface
{
    public function getValue(string $key, mixed $default = null): mixed;

    public function setValue(string $key, mixed $value, string $group = 'general'): void;

    public function getGroup(string $group): array;

    public function getAll(): array;

    public function flushCache(): void;
}
