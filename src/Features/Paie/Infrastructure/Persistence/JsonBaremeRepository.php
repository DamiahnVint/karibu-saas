<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Bareme;
use Src\Features\Paie\Domain\Contracts\BaremeRepositoryInterface;

class JsonBaremeRepository implements BaremeRepositoryInterface
{
    public function getConfig(string $type, int $annee, int $tenantId): ?array
    {
        $bareme = Bareme::where('tenant_id', $tenantId)
            ->where('type', $type)
            ->where('annee', $annee)
            ->where('actif', true)
            ->first();

        return $bareme?->config;
    }

    public function getDefaultConfig(string $type): array
    {
        return Bareme::getDefaultConfig($type);
    }

    public function save(int $tenantId, string $type, int $annee, array $config): bool
    {
        $bareme = Bareme::where('tenant_id', $tenantId)
            ->where('type', $type)
            ->where('annee', $annee)
            ->first();

        if ($bareme) {
            $bareme->config = $config;
            $bareme->actif = true;
        } else {
            $bareme = new Bareme();
            $bareme->tenant_id = $tenantId;
            $bareme->type = $type;
            $bareme->annee = $annee;
            $bareme->config = $config;
            $bareme->actif = true;
        }

        return $bareme->save();
    }
}
