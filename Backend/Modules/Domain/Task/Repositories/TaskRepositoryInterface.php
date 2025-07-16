<?php

namespace Modules\Domain\Task\Repositories;

use Modules\Domain\Task\Entities\Task;

interface TaskRepositoryInterface
{
    public function getAll(): array;

    public function create(Task $task): Task;

    public function findById(int $id): ?Task;

    public function update(Task $task): Task;

    public function delete(int $id): bool;

    public function count(): int;
}
