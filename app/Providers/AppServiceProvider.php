<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \Src\Features\Auth\Domain\Contracts\UserRepositoryInterface::class,
            \Src\Features\Auth\Infrastructure\EloquentUserRepository::class,
        );

        $this->app->bind(
            \Src\Features\Cms\Domain\Contracts\PageRepositoryInterface::class,
            \Src\Features\Cms\Infrastructure\Persistence\EloquentPageRepository::class,
        );

        $this->app->bind(
            \Src\Features\Cms\Domain\Contracts\SectionRepositoryInterface::class,
            \Src\Features\Cms\Infrastructure\Persistence\EloquentSectionRepository::class,
        );

        $this->app->bind(
            \Src\Features\Cms\Domain\Contracts\SettingRepositoryInterface::class,
            \Src\Features\Cms\Infrastructure\Persistence\EloquentSettingRepository::class,
        );

        $this->app->bind(
            \Src\Features\Cms\Domain\Contracts\FormSubmissionRepositoryInterface::class,
            \Src\Features\Cms\Infrastructure\Persistence\EloquentFormSubmissionRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
