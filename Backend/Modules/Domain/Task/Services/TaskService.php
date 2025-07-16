<?php

namespace Modules\Domain\Task\Services;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;

class TaskService
{
    /**
     * Service for managing tasks.
     * Servicio para gestionar tareas.
     */
    private TaskRepositoryInterface $taskRepository;

    /**
     * TaskService constructor.
     *
     * Inicializa el servicio de tareas con el repositorio de tareas.
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Create a new task.
     * Crea una nueva tarea.
     *
     * @param  string  $title  The title of the task.
     * @param  string  $description  The description of the task (optional).
     * @return Task Returns the created task entity.
     */
    public function createTask(string $title, string $description = ''): Task
    {
        $task = new Task(
            id: 0, // El repositorio se encarga de asignar el ID real
            title: $title,
            description: $description,
            status: 'pending',
            color: null,
            priority: 1,
            due_date: null
        );

        return $this->taskRepository->create($task);
    }

    /**
     * Create a new task with detailed information.
     * Crea una nueva tarea con información detallada.
     *
     * @param  string  $title  The title of the task.
     * @param  string  $description  The description of the task.
     * @param  string  $status  The status of the task.
     * @param  string|null  $color  The color of the task.
     * @param  int  $priority  The priority of the task.
     * @param  \DateTime|null  $dueDate  The due date of the task.
     * @return Task Returns the created task entity.
     */
    public function createTaskWithDetails(
        string $title,
        string $description = '',
        string $status = 'pending',
        ?string $color = null,
        int $priority = 1,
        ?\DateTime $dueDate = null
    ): Task {
        // Aquí puedes agregar validaciones de dominio específicas
        $this->validateTaskData($title, $status, $priority);

        $task = new Task(
            id: 0, // El repositorio se encarga de asignar el ID real
            title: $title,
            description: $description,
            status: $status,
            color: $color,
            priority: $priority,
            due_date: $dueDate
        );

        return $this->taskRepository->create($task);
    }

    /**
     * Validate task domain rules.
     * Valida las reglas de dominio de la tarea.
     */
    private function validateTaskData(string $title, string $status, int $priority): void
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException('Task title cannot be empty');
        }

        $validStatuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        if (! in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid task status');
        }

        if ($priority < 1 || $priority > 5) {
            throw new \InvalidArgumentException('Task priority must be between 1 and 5');
        }
    }
}
