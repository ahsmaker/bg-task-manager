<?php

namespace App\Services;

use App\Exceptions\TaskCategoryNotFoundException;
use App\Models\TaskCategory;
use App\Repositories\Interfaces\TaskCategoryRepositoryInterface;
use Illuminate\Support\Collection;

class TaskCategoryService
{
    protected TaskCategoryRepositoryInterface $taskCategoryRepository;

    public function __construct(TaskCategoryRepositoryInterface $taskCategoryRepository)
    {
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    public function getAllTaskCategories(): Collection
    {
        return $this->taskCategoryRepository->all();
    }

    public function createTaskCategory(array $data): TaskCategory
    {
        return $this->taskCategoryRepository->create($data);
    }

    /**
     * @throws TaskCategoryNotFoundException
     */
    public function updateTaskCategory($id, array $data): ?TaskCategory
    {
        $taskCategory = $this->taskCategoryRepository->find($id);
        if (!$taskCategory) {
            throw new TaskCategoryNotFoundException();
        }
        return $this->taskCategoryRepository->update($id, $data);
    }

    /**
     * @throws TaskCategoryNotFoundException
     */
    public function deleteTaskCategory($id): void
    {
        $taskCategory = $this->taskCategoryRepository->find($id);
        if (!$taskCategory) {
            throw new TaskCategoryNotFoundException();
        }
        $this->taskCategoryRepository->delete($id);
    }
}
