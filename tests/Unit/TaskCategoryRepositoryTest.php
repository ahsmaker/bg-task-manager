<?php

namespace Tests\Unit;

use App\Models\TaskCategory;
use App\Models\User;
use App\Repositories\TaskCategoryRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $taskCategoryRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // authenticate user
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->taskCategoryRepository = new TaskCategoryRepository();
    }

    public function test_all_task_categories()
    {
        TaskCategory::factory()->count(3)->create();

        $taskCategories = $this->taskCategoryRepository->all();

        $this->assertCount(3, $taskCategories);
    }

    public function test_one_task_category()
    {
        $id = 3;

        TaskCategory::factory()->count(3)->create();

        $taskCategory = $this->taskCategoryRepository->find($id);

        $this->assertEquals($id, $taskCategory->id);
    }

    public function test_create_task_category()
    {
        $category_name = 'Category 1';
        $taskCategoryData = [
            'name' => $category_name,
        ];

        $taskCategory = $this->taskCategoryRepository->create($taskCategoryData);

        $this->assertDatabaseHas('task_categories', ['name' => $category_name]);
        $this->assertEquals($category_name, $taskCategory->name);
    }

    public function test_update_task_category()
    {
        $taskCategory = TaskCategory::factory()->create();
        $category_name = 'Updated Category';

        $updateData = [
            'name' => $category_name,
        ];

        $updatedTaskCategory = $this->taskCategoryRepository->update($taskCategory->id, $updateData);
        $this->assertEquals($category_name, $updatedTaskCategory->name);
    }

    public function test_delete_task_category()
    {
        $taskCategory = TaskCategory::factory()->create();

        $this->taskCategoryRepository->delete($taskCategory->id);

        $this->assertDatabaseMissing('task_categories', ['id' => $taskCategory->id]);
    }
}

