<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class GetAllTasksUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Execute the use case to get all tasks.
     * Ejecuta el caso de uso para obtener todas las tareas.
     *
     * @return array Returns an array of all task entities.
     *
     * @throws \Exception If there is an error retrieving the tasks.
     */
    public function execute(): array
    {
        return $this->taskRepository->getAll();
    }
}
