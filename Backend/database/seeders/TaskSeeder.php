<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Domain\Task\Services\TaskService;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $taskService = app(TaskService::class);

        // Usar la función simple para crear tareas básicas de ejemplo
        $taskService->createTask(
            'Configurar el proyecto',
            'Configurar el entorno de desarrollo y las dependencias'
        );

        $taskService->createTask(
            'Implementar autenticación',
            'Crear el sistema de login y registro de usuarios'
        );

        $taskService->createTask(
            'Diseñar la interfaz',
            'Crear mockups y prototipos de la aplicación'
        );

        echo "✅ Tareas de ejemplo creadas exitosamente\n";
    }
}
