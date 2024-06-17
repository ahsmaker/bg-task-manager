<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?Task;

    public function create(array $data): Task;

    public function update($id, array $data): ?Task;

    public function delete($id): void;

    public function filter(array $criteria): Collection;
}