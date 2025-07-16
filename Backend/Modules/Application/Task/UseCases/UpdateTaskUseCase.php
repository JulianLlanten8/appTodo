<?php

namespace Modules\Application\Task\UseCases;

use DateTime;
use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class UpdateTaskUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to update an existing task.
     * Ejecuta el caso de uso para actualizar una tarea existente.
     *
     * @param  int  $id  The ID of the task to update.
     * @param  array  $data  The data to update the task with, including title, description,status, color, priority, and due date.
     * @return Task Returns the updated task entity.
     */
    public function execute(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);

        $dueDate = isset($data['due_date']) ? new DateTime($data['due_date']) : null;

        throw_unless($task, \Exception::class, "Task with ID {$id} not found."); // Ejecuta una excepción si la tarea no existe.

        $task->title = $data['title'] ?? $task->title;
        $task->description = $data['description'] ?? $task->description;
        $task->status = $data['status'] ?? $task->status;
        $task->color = $data['color'] ?? $task->color;
        $task->priority = $data['priority'] ?? $task->priority;
        $task->due_date = $dueDate ?? $task->due_date;

        return $this->taskRepository->update($task);
    }
}
