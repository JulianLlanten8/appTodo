<?php

namespace Modules\InterfaceAdapters\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Application\Task\UseCases\CountTasksUseCase;
use Modules\Application\Task\UseCases\CreateTaskUseCase;
use Modules\Application\Task\UseCases\DeleteTaskUseCase;
use Modules\Application\Task\UseCases\FindTaskByIdUseCase;
use Modules\Application\Task\UseCases\GetAllTasksUseCase;
use Modules\Application\Task\UseCases\UpdateTaskUseCase;
use Modules\InterfaceAdapters\Requests\DeleteTaskRequest;
use Modules\InterfaceAdapters\Requests\StoreTaskRequest;
use Modules\InterfaceAdapters\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct(
        private CreateTaskUseCase $createTaskUseCase,
        private GetAllTasksUseCase $getAllTasksUseCase,
        private FindTaskByIdUseCase $findTaskByIdUseCase,
        private CountTasksUseCase $countTasksUseCase,
        private DeleteTaskUseCase $deleteTaskUseCase,
        private UpdateTaskUseCase $updateTaskUseCase,
    ) {}

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Lista todas las tareas",
     *     description="Obtiene una lista completa de todas las tareas disponibles",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tareas obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $tasks = $this->getAllTasksUseCase->execute();

        return response()->json($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Crea una nueva tarea",
     *     description="Crea una nueva tarea con los datos proporcionados",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para crear una nueva tarea",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"title"},
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Título de la tarea",
     *                 maxLength=255,
     *                 example="Completar documentación"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descripción detallada de la tarea",
     *                 example="Completar la documentación de la API REST"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Estado de la tarea",
     *                 enum={"pending", "completed", "in_progress"},
     *                 example="pending"
     *             ),
     *             @OA\Property(
     *                 property="color",
     *                 type="string",
     *                 description="Color de la tarea (código hexadecimal)",
     *                 example="#FF5733"
     *             ),
     *             @OA\Property(
     *                 property="priority",
     *                 type="integer",
     *                 description="Prioridad de la tarea (1-5)",
     *                 minimum=1,
     *                 maximum=5,
     *                 example=3
     *             ),
     *             @OA\Property(
     *                 property="due_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de vencimiento",
     *                 example="2025-08-15T10:30:00Z"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarea creada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="array",
     *                     @OA\Items(type="string", example="The title field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->createTaskUseCase->execute($request->validated());

        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Muestra una tarea específica",
     *     description="Obtiene los detalles de una tarea específica por su ID",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID único de la tarea",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarea encontrada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarea no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task with ID 1 not found.")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $task = $this->findTaskByIdUseCase->execute($id);

        return response()->json($task);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/count",
     *     summary="Cuenta el total de tareas",
     *     description="Obtiene el número total de tareas en el sistema",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="Conteo obtenido exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="count",
     *                 type="integer",
     *                 description="Número total de tareas",
     *                 example=25
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     *
     * @throws \Exception
     */
    public function count(): JsonResponse
    {
        $count = $this->countTasksUseCase->execute();

        return response()->json(['count' => $count]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Elimina una tarea específica",
     *     description="Elimina permanentemente una tarea del sistema",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID único de la tarea a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tarea eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarea no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task with ID 1 not found.")
     *         )
     *     )
     * )
     */
    public function destroy(DeleteTaskRequest $request, $id): JsonResponse
    {
        $this->deleteTaskUseCase->execute($id);

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Actualiza una tarea específica",
     *     description="Actualiza los datos de una tarea existente",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID único de la tarea a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados para la tarea",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Título actualizado de la tarea",
     *                 maxLength=255,
     *                 example="Documentación actualizada"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descripción actualizada de la tarea",
     *                 example="Actualizar la documentación de la API"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Estado actualizado de la tarea",
     *                 enum={"pending", "completed", "in_progress"},
     *                 example="in_progress"
     *             ),
     *             @OA\Property(
     *                 property="color",
     *                 type="string",
     *                 description="Color actualizado de la tarea",
     *                 example="#00FF00"
     *             ),
     *             @OA\Property(
     *                 property="priority",
     *                 type="integer",
     *                 description="Prioridad actualizada de la tarea",
     *                 minimum=1,
     *                 maximum=5,
     *                 example=4
     *             ),
     *             @OA\Property(
     *                 property="due_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de vencimiento actualizada",
     *                 example="2025-08-20T15:30:00Z"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarea actualizada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarea no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task with ID 1 not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="array",
     *                     @OA\Items(type="string", example="The title field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = $this->updateTaskUseCase->execute($id, $request->validated());

        return response()->json($task);
    }
}
