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

        $dueDate = null;

        if (!empty($data['due_date'])) {
            try {
                $dueDate = new DateTime($data['due_date']);
            } catch (\Exception $e) {
                throw_unless(
                    false,
                    \InvalidArgumentException::class,
                    'Invalid date format for due_date.'
                );
                $dueDate = null;
            }
        }

        $task = new Task(
            id: 0,
            title: $data['title'],
            description: $data['description'] ?? '',
            status: $data['status'] ?? 'pending',
            color: $data['color'] ?? null,
            priority: $data['priority'] ?? 1,
            due_date: $dueDate ? $dueDate->format('Y-m-d H:i:s') : null,
        );

        return $this->taskRepository->create($task);
    }
}
