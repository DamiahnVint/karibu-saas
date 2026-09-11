<?php

namespace Src\Features\Cms\Application\Actions;

use Src\Features\Cms\Domain\Contracts\SettingRepositoryInterface;

class UpdateSettingAction
{
    public function __construct(
        protected SettingRepositoryInterface $settings,
    ) {}

    public function execute(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->settings->setValue($key, $value);
        }
    }
}
