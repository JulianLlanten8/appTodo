<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class FindTaskByIdUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to find a task by its ID.
     */
    public function execute(int $id): ?Task
    {
        $task = $this->taskRepository->findById($id);
        throw_unless($task, \Exception::class, "Task with ID {$id} not found.");

        return $task;
    }
}
