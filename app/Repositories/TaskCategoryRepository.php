<?php

namespace App\Repositories;

use App\Models\TaskCategory;
use App\Repositories\Interfaces\TaskCategoryRepositoryInterface;
use Illuminate\Support\Collection;

class TaskCategoryRepository implements TaskCategoryRepositoryInterface
{
    public function all(): Collection
    {
        return TaskCategory::all();
    }

    public function find($id): ?TaskCategory
    {
        return TaskCategory::find($id);
    }

    public function create(array $data): TaskCategory
    {
        return TaskCategory::create($data);
    }

    public function update($id, array $data): TaskCategory
    {
        $task = TaskCategory::find($id);
        $task->update($data);

        return $task;
    }

    public function delete($id): void
    {
        TaskCategory::find($id)->delete();
    }

}
