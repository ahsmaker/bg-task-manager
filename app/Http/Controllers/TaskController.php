<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        $tasks = $query->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:512',
            'description' => 'required|string',
            'due_date'    => 'required|date|after:today',
            'category_id' => 'required|integer|exists:task_categories,id',
            'status'      => 'required|in:' . implode(',', array_keys(Task::getStatusOptions())),
            'priority'    => 'required|in:' . implode(',', array_keys(Task::getPriorityOptions())),
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task = auth()->user()->tasks()->create($request->all());

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|max:512',
            'description' => 'sometimes|required|string',
            'due_date'    => 'sometimes|required|date|after:today',
            'category_id' => 'sometimes|required|integer|exists:task_categories,id',
            'status'      => 'sometimes|required|in:' . implode(',', array_keys(Task::getStatusOptions())),
            'priority'    => 'sometimes|required|in:' . implode(',', array_keys(Task::getPriorityOptions())),
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
