<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class GetAllTasksUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to get all tasks.
     */
    public function execute(): array
    {
        return $this->taskRepository->getAll();
    }
}
