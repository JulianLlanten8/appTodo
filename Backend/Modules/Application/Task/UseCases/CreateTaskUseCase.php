<?php

namespace Modules\Application\Task\UseCases;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;
use DateTime;

class CreateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Execute the use case to create a new task.
     */
    public function execute(array $data): Task
    {


        $task = new Task(
            id: 0,
            title: $data['title'],
            description: $data['description'] ?? '',
            status: $data['status'] ?? 'pending',
            color: $data['color'] ?? null,
            priority: $data['priority'] ?? 1,
            due_date: new DateTime($data['due_date'] ?? 'now')
        );

        return $this->taskRepository->create($task);
    }
}
