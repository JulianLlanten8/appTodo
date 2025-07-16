<?php

namespace Modules\Domain\Task\Services;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class TaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(string $title, string $description = ''): Task
    {
        // Aquí podrías tener validaciones de dominio, reglas de negocio, etc.
        $task = new Task(
            id: 0, // El repositorio se encarga de asignar el ID real
            title: $title,
            description: $description
        );

        return $this->taskRepository->create($task);
    }

    public function listTasks(): array
    {
        return $this->taskRepository->getAll();
    }
}
