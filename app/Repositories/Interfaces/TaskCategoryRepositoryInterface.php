<?php

namespace App\Repositories\Interfaces;

use App\Models\TaskCategory;
use Illuminate\Support\Collection;

interface TaskCategoryRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?TaskCategory;

    public function create(array $data): TaskCategory;

    public function update($id, array $data): ?TaskCategory;

    public function delete($id): void;
}
