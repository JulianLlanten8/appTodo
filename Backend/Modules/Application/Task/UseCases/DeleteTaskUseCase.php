<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class DeleteTaskUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to delete a task by its ID.
     * Ejecuta el caso de uso para eliminar una tarea por su ID.
     * 
     * @param int $id The ID of the task to delete.
     * @return bool Returns true if the task was successfully deleted, false otherwise.
     * @throws \Exception If the task with the given ID does not exist.
     */
    public function execute(int $id): bool
    {
        $task = $this->taskRepository->findById($id);
        throw_unless($task, \Exception::class, "Task with ID {$id} not found.");

        return $this->taskRepository->delete($id);
    }
}
