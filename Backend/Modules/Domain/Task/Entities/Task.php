<?php

namespace Modules\Domain\Task\Entities;

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     title="Task",
 *     description="Entidad de tarea",
 *     required={"id", "title", "status"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único de la tarea",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Título de la tarea",
 *         maxLength=255,
 *         example="Completar documentación"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Descripción detallada de la tarea",
 *         example="Completar la documentación de la API REST"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Estado actual de la tarea",
 *         enum={"pending", "completed", "in_progress"},
 *         example="pending"
 *     ),
 *     @OA\Property(
 *         property="color",
 *         type="string",
 *         description="Color asignado a la tarea (código hexadecimal)",
 *         nullable=true,
 *         example="#FF5733"
 *     ),
 *     @OA\Property(
 *         property="priority",
 *         type="integer",
 *         description="Prioridad de la tarea (1=baja, 5=alta)",
 *         minimum=1,
 *         maximum=5,
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="due_date",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de vencimiento de la tarea",
 *         nullable=true,
 *         example="2025-08-15T10:30:00Z"
 *     )
 * )
 */
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
