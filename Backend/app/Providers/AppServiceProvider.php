<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface; // Importa la interfaz
use Modules\Infrastructure\Persistence\Eloquent\Repositories\EloquentTaskRepository; // Importa la implementación

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskRepositoryInterface::class,
            EloquentTaskRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
