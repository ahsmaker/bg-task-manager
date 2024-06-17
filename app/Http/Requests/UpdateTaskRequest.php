<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'title'       => 'sometimes|required|string|max:512',
            'description' => 'sometimes|required|string',
            'due_date'    => 'sometimes|required|date|after:today',
            'status'      => 'sometimes|required|in:' . implode(',', array_keys(Task::getStatusOptions())),
            'category_id' => 'sometimes|required|integer|exists:task_categories,id',
            'priority'    => 'sometimes|required|in:' . implode(',', array_keys(Task::getPriorityOptions())),
        ];
    }
}
