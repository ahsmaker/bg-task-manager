<?php

namespace App\Http\Controllers;

use App\Exceptions\TaskNotFoundException;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->filterTasks($request->all());

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return response()->json($task, 201);
    }

    /**
     * @throws TaskNotFoundException
     */
    public function show($id)
    {
        $task = $this->taskService->getTaskById($id);
        return response()->json($task);
    }

    /**
     * @throws TaskNotFoundException
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->validated());
        return response()->json($task);
    }

    /**
     * @throws TaskNotFoundException
     */
    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return response()->json(null, 204);
    }
}
