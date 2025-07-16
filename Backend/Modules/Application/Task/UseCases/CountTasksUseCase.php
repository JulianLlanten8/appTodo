<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class CountTasksUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to count all tasks.
     * Ejecuta el caso de uso para contar todas las tareas.
     */
    public function execute(): int
    {
        return $this->taskRepository->count();
    }
}
