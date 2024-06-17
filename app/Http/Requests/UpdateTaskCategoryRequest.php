<?php

namespace App\Http\Requests;

class UpdateTaskCategoryRequest extends BaseFormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:512|unique:task_categories,name,' . $this['id'],
        ];
    }
}
