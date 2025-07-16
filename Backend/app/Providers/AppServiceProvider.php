<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface; // Importa la interfaz
use Modules\Domain\Task\Services\TaskService; // Importa la implementación
use Modules\Infrastructure\Persistence\Eloquent\Repositories\EloquentTaskRepository; // Importa el TaskService

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el repositorio
        $this->app->bind(
            TaskRepositoryInterface::class,
            EloquentTaskRepository::class
        );

        // Registrar el TaskService
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService(
                $app->make(TaskRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
