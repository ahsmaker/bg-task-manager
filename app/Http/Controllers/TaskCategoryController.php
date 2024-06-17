<?php

namespace App\Http\Controllers;

use App\Exceptions\TaskCategoryNotFoundException;
use App\Http\Requests\StoreTaskCategoryRequest;
use App\Http\Requests\UpdateTaskCategoryRequest;
use App\Services\TaskCategoryService;

class TaskCategoryController extends Controller
{
    protected TaskCategoryService $taskCategoryService;

    public function __construct(TaskCategoryService $taskCategoryService)
    {
        $this->taskCategoryService = $taskCategoryService;
    }
    public function index()
    {
        $categories = $this->taskCategoryService->getAllTaskCategories();
        return response()->json($categories);
    }

    public function store(StoreTaskCategoryRequest $request)
    {
        $task = $this->taskCategoryService->createTaskCategory($request->validated());
        return response()->json($task, 201);
    }

    /**
     * @throws TaskCategoryNotFoundException
     */
    public function update(UpdateTaskCategoryRequest $request, $id)
    {
        $task = $this->taskCategoryService->updateTaskCategory($id, $request->validated());
        return response()->json($task);
    }

    /**
     * @throws TaskCategoryNotFoundException
     */
    public function destroy($id)
    {
        $this->taskCategoryService->deleteTaskCategory($id);
        return response()->json(null, 204);
    }
}
