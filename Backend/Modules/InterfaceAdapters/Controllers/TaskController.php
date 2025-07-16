<?php

namespace Modules\InterfaceAdapters\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Application\Task\UseCases\CountTasksUseCase;
use Modules\Application\Task\UseCases\CreateTaskUseCase;
use Modules\Application\Task\UseCases\DeleteTaskUseCase;
use Modules\Application\Task\UseCases\FindTaskByIdUseCase;
use Modules\Application\Task\UseCases\GetAllTasksUseCase;
use Modules\Application\Task\UseCases\UpdateTaskUseCase;
use Modules\InterfaceAdapters\Requests\DeleteTaskRequest;
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
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tasks = $this->getAllTasksUseCase->execute();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $task = $this->createTaskUseCase->execute($request->only('title', 'description', 'status', 'color', 'priority', 'due_date'));

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $task = $this->findTaskByIdUseCase->execute($id);

        return response()->json($task);
    }

    /**
     * Count the total number of tasks.
     *
     * @throws \Exception
     */
    public function count(): JsonResponse
    {
        $count = $this->countTasksUseCase->execute();

        return response()->json(['count' => $count]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteTaskRequest $request, $id): JsonResponse
    {
        $this->deleteTaskUseCase->execute($id);

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = $this->updateTaskUseCase->execute($id, $request->validated());

        return response()->json($task);
    }
}
