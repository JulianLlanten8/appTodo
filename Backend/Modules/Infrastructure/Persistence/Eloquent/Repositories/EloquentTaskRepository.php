<?php

namespace Modules\Infrastructure\Persistence\Eloquent\Repositories;

use Modules\Domain\Task\Entities\Task;
use Modules\Domain\Task\Repositories\TaskRepositoryInterface;
use Modules\Infrastructure\Persistence\Eloquent\Models\TaskModel;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function getAll(): array
    {
        $models = TaskModel::all();

        return $models->map(function ($model) {
            return new Task(
                id: $model->id,
                title: $model->title,
                description: $model->description,
                status: $model->status,
                color: $model->color,
                priority: $model->priority,
                due_date: $model->due_date
            );
        })->toArray();
    }

    public function create(Task $task): Task
    {
        $model = TaskModel::create([
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'color' => $task->color,
            'priority' => $task->priority,
            'due_date' => $task->due_date?->format('Y-m-d H:i:s'),
        ]);

        return new Task(
            id: $model->id,
            title: $model->title,
            description: $model->description,
            status: $model->status,
            color: $model->color,
            priority: $model->priority,
            due_date: $model->due_date ? new \DateTime($model->due_date) : null
        );
    }

    public function findById(int $id): ?Task
    {
        $model = TaskModel::find($id);
        if (! $model) {
            return null;
        }

        return new Task(
            id: $model->id,
            title: $model->title,
            description: $model->description,
            status: $model->status,
            color: $model->color,
            priority: $model->priority,
            due_date: $model->due_date ? new \DateTime($model->due_date) : null
        );
    }

    /**
     * Update an existing task.
     */
    public function update(Task $task): Task
    {
        $model = TaskModel::find($task->id);
        if (! $model) {
            throw new \Exception('Task not found');
        }

        $model->title = $task->title;
        $model->description = $task->description;
        $model->status = $task->status;
        $model->color = $task->color;
        $model->priority = $task->priority;
        $model->due_date = $task->due_date;
        // Save the updated model in the database
        $model->save();

        return new Task($model->id, $model->title, $model->description);
    }

    public function delete(int $id): bool
    {
        $model = TaskModel::find($id);
        if ($model) {
            $model->delete();

            return true;
        }

        return false;
    }

    public function count(): int
    {
        return TaskModel::count();
    }
}
