<?php

namespace Tests\Unit;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\TestCase;
use App\Services\TaskService;
use App\Models\Task;
use App\Exceptions\TaskNotFoundException;
use Mockery;
use Illuminate\Support\Collection;

class TaskServiceTest extends TestCase
{
    protected $taskRepository;
    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        // mock TaskRepository
        $this->taskRepository = Mockery::mock(TaskRepositoryInterface::class);
        $this->taskService = new TaskService($this->taskRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_tasks()
    {
        $tasks = new Collection([new Task(['title' => 'Test Task'])]);

        $this->taskRepository->shouldReceive('filter')->once()->andReturn($tasks);

        $result = $this->taskService->filterTasks([]);

        $this->assertEquals($tasks, $result);
    }

    public function test_get_task_by_id()
    {
        $task = new Task(['id' => 1, 'title' => 'Test Task']);

        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn($task);

        $result = $this->taskService->getTaskById(1);

        $this->assertEquals($task, $result);
    }

    public function test_get_task_by_id_not_found()
    {
        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn(null);

        $this->expectException(TaskNotFoundException::class);

        $this->taskService->getTaskById(1);
    }

    public function test_create_task()
    {
        $taskData = [
            'title'       => 'Test Task',
            'description' => 'This is a test task',
            'due_date'    => now(),
            'status'      => 0,
            'category_id' => 1,
            'priority'    => 0,
        ];

        $task = new Task($taskData);

        $this->taskRepository->shouldReceive('create')->with($taskData)->once()->andReturn($task);

        $result = $this->taskService->createTask($taskData);

        $this->assertEquals($task, $result);
    }

    public function test_update_task()
    {
        $taskData = [
            'title'       => 'Updated Task',
            'description' => 'This is an updated test task',
            'due_date'    => now(),
            'status'      => 0,
            'category_id' => 1,
            'priority'    => 0,
        ];

        $task = new Task(['id' => 1, 'title' => 'Test Task']);

        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn($task);
        $this->taskRepository->shouldReceive('update')->with(1, $taskData)->once()->andReturn($task);

        $result = $this->taskService->updateTask(1, $taskData);

        $this->assertEquals($task, $result);
    }

    public function test_update_task_not_found()
    {
        $taskData = [
            'title'       => 'Updated Task',
            'description' => 'This is an updated test task',
            'due_date'    => now(),
            'status'      => 'in-progress',
            'category_id' => 1,
            'priority'    => 4,
        ];

        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn(null);

        $this->expectException(TaskNotFoundException::class);

        $this->taskService->updateTask(1, $taskData);
    }

    public function test_delete_task()
    {
        $task = new Task(['id' => 1, 'title' => 'Test Task']);

        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn($task);
        $this->taskRepository->shouldReceive('delete')->with(1)->once();

        $this->taskService->deleteTask(1);

        // if no exception is thrown the test succeeds
        $this->assertTrue(true);
    }

    public function test_delete_task_not_found()
    {
        $this->taskRepository->shouldReceive('find')->with(1)->once()->andReturn(null);

        $this->expectException(TaskNotFoundException::class);

        $this->taskService->deleteTask(1);
    }

    public function test_filter_tasks()
    {
        $criteria = ['status' => Task::STATUS_PENDING];
        $tasks = new Collection([new Task(['title' => 'Pending Task', 'status' => Task::STATUS_PENDING])]);

        $this->taskRepository->shouldReceive('filter')->with($criteria)->once()->andReturn($tasks);

        $result = $this->taskService->filterTasks($criteria);

        $this->assertEquals($tasks, $result);
    }
}
