<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:512',
            'description' => 'required|string',
            'due_date'    => 'required|date|after:today',
            'category_id' => 'required|integer|exists:task_categories,id',
            'status'      => 'required|in:' . implode(',', array_keys(Task::getStatusOptions())),
            'priority'    => 'required|in:' . implode(',', array_keys(Task::getPriorityOptions())),
        ];
    }
}
