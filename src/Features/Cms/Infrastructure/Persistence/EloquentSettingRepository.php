<?php

namespace Src\Features\Cms\Infrastructure\Persistence;

use App\Models\CmsSetting;
use Src\Features\Cms\Domain\Contracts\SettingRepositoryInterface;

class EloquentSettingRepository implements SettingRepositoryInterface
{
    public function __construct(
        protected CmsSetting $model,
    ) {}

    public function getValue(string $key, mixed $default = null): mixed
    {
        return $this->model::getValue($key, $default);
    }

    public function setValue(string $key, mixed $value, string $group = 'general'): void
    {
        $this->model::setValue($key, $value, $group);
    }

    public function getGroup(string $group): array
    {
        return $this->model::getGroup($group);
    }

    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }

    public function flushCache(): void
    {
        $this->model::flushCache();
    }
}
