<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     *
     * @throws TaskNotFoundException
     */
    public function getTaskById($id): Task
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        return $task;
    }


    public function createTask(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    /**
     *
     * @throws TaskNotFoundException
     */
    public function updateTask($id, array $data): ?Task
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        return $this->taskRepository->update($id, $data);
    }

    /**
     *
     * @throws TaskNotFoundException
     */
    public function deleteTask($id): void
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        $this->taskRepository->delete($id);
    }

    /**
     * @param array $criteria
     * @return Collection
     */
    public function filterTasks(array $criteria): Collection
    {
        return $this->taskRepository->filter($criteria);
    }
}
