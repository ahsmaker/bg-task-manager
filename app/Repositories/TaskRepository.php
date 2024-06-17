<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::all();
    }

    public function find($id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update($id, array $data): Task
    {
        $task = Task::find($id);
        $task->update($data);

        return $task;
    }

    public function delete($id): void
    {
        Task::find($id)->delete();
    }

    public function filter(array $criteria): Collection
    {
        $query = Task::query();

        $filterableFields = ['status', 'category_id', 'priority'];

        foreach($criteria as $field => $value) {
            if(in_array($field, $filterableFields)) {
                $query->where($field, $value);
            }
        }

        return $query->get();
    }
}

