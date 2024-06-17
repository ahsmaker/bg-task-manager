<?php

namespace Tests\Unit;

use App\Exceptions\TaskCategoryNotFoundException;
use App\Models\TaskCategory;
use App\Repositories\Interfaces\TaskCategoryRepositoryInterface;
use App\Services\TaskCategoryService;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Collection;

class TaskCategoryServiceTest extends TestCase
{
    protected $taskCategoryRepository;
    protected $taskCategoryService;

    protected function setUp(): void
    {
        parent::setUp();

        // mock TaskCategoryRepository
        $this->taskCategoryRepository = Mockery::mock(TaskCategoryRepositoryInterface::class);
        $this->taskCategoryService = new TaskCategoryService($this->taskCategoryRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_task_categories()
    {
        $task_categories = new Collection([new TaskCategory(['name' => 'Category'])]);

        $this->taskCategoryRepository->shouldReceive('all')->once()->andReturn($task_categories);

        $result = $this->taskCategoryService->getAllTaskCategories();

        $this->assertEquals($task_categories, $result);
    }


    public function test_create_task()
    {
        $taskCategoryData = [
            'name'       => 'Test Category',
        ];

        $taskCategory = new TaskCategory($taskCategoryData);

        $this->taskCategoryRepository->shouldReceive('create')->with($taskCategoryData)->once()->andReturn($taskCategory);

        $result = $this->taskCategoryService->createTaskCategory($taskCategoryData);

        $this->assertEquals($taskCategory, $result);
    }

    public function test_update_task()
    {
        $taskCategoryData = [
            'name'       => 'Updated Category',
        ];

        $taskCategory = new TaskCategory(['id' => 1, 'title' => 'Test Category']);

        $this->taskCategoryRepository->shouldReceive('find')->with(1)->once()->andReturn($taskCategory);
        $this->taskCategoryRepository->shouldReceive('update')->with(1, $taskCategoryData)->once()->andReturn($taskCategory);

        $result = $this->taskCategoryService->updateTaskCategory(1, $taskCategoryData);

        $this->assertEquals($taskCategory, $result);
    }

    public function test_update_task_not_found()
    {
        $taskCategoryData = [
            'name'       => 'Updated Category',
        ];

        $this->taskCategoryRepository->shouldReceive('find')->with(1)->once()->andReturn(null);

        $this->expectException(TaskCategoryNotFoundException::class);

        $this->taskCategoryService->updateTaskCategory(1, $taskCategoryData);
    }

    public function test_delete_task()
    {
        $taskCategory = new TaskCategory(['id' => 1, 'name' => 'Test Task']);

        $this->taskCategoryRepository->shouldReceive('find')->with(1)->once()->andReturn($taskCategory);
        $this->taskCategoryRepository->shouldReceive('delete')->with(1)->once();

        $this->taskCategoryService->deleteTaskCategory(1);

        // if no exception is thrown the test succeeds
        $this->assertTrue(true);
    }

    public function test_delete_task_not_found()
    {
        $this->taskCategoryRepository->shouldReceive('find')->with(1)->once()->andReturn(null);

        $this->expectException(TaskCategoryNotFoundException::class);

        $this->taskCategoryService->deleteTaskCategory(1);
    }

}
