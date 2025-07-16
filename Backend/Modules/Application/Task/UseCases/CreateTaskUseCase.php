<?php

namespace Modules\Application\Task\UseCases;

use DateTime;
use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Services\TaskService;

class CreateTaskUseCase
{
    public function __construct(
        private TaskService $taskService
    ) {}

    /**
     * Execute the use case to create a new task.
     * Ejecuta el caso de uso para crear una nueva tarea.
     *
     * @param  array  $data  The data for the new task, including title, description, status, color, priority, and due date.
     * @return Task Returns the created task entity.
     */
    public function execute(array $data): Task
    {
        // El Use Case maneja la validación y transformación de datos de entrada
        return $this->taskService->createTaskWithDetails(
            title: $data['title'],
            description: $data['description'] ?? '',
            status: $data['status'] ?? 'pending',
            color: $data['color'] ?? null,
            priority: $data['priority'] ?? 1,
            dueDate: new DateTime($data['due_date'] ?? 'now') // Asigna la fecha de vencimiento, o la fecha actual si no se proporciona
        );
    }
}
