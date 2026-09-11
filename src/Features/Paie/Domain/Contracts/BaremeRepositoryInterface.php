<?php

namespace Src\Features\Paie\Domain\Contracts;

interface BaremeRepositoryInterface
{
    public function getConfig(string $type, int $annee, int $tenantId): ?array;

    public function getDefaultConfig(string $type): array;

    public function save(int $tenantId, string $type, int $annee, array $config): bool;
}
