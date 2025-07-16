<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class UpdateTaskUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to update an existing task.
     */
    public function execute(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);
        throw_unless($task, \Exception::class, "Task with ID {$id} not found."); // Ejecuta una excepción si la tarea no existe.

        $task->title = $data['title'] ?? $task->title;
        $task->description = $data['description'] ?? $task->description;
        $task->status = $data['status'] ?? $task->status;
        $task->color = $data['color'] ?? $task->color;
        $task->priority = $data['priority'] ?? $task->priority;
        $task->due_date = $data['due_date'] ?? $task->due_date;

        return $this->taskRepository->update($task);
    }
}
