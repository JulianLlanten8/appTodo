<?php

namespace Modules\Domain\Task\Entities;

class Task
{
    public function __construct(
        public readonly int $id,
        public string $title,
        public string $description,
        public string $status = 'pending',
        public ?string $color = null,
        public int $priority = 1,
        public ?\DateTime $due_date = null
    ) {}
}
