<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // authenticate user
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->taskRepository = new TaskRepository();
    }

    public function test_all_tasks()
    {
        Task::factory()->count(3)->create();

        $tasks = $this->taskRepository->all();

        $this->assertCount(3, $tasks);
    }

    public function test_find_task_by_id()
    {
        $task = Task::factory()->create();

        $foundTask = $this->taskRepository->find($task->id);

        $this->assertNotNull($foundTask);
        $this->assertEquals($task->id, $foundTask->id);
    }

    public function test_create_task()
    {
        $taskData = [
            'title'       => 'New Task',
            'description' => 'Task description',
            'due_date'    => now(),
            'status'      => Task::STATUS_IN_PROGRESS,
            'category_id' => 1,
            'priority'    => Task::PRIORITY_NORMAL,
        ];

        $task = $this->taskRepository->create($taskData);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
        $this->assertEquals('New Task', $task->title);

        // check that user_id was set correctly
        $this->assertEquals($this->user->id, $task->user_id);
    }

    public function test_update_task()
    {
        $task = Task::factory()->create();

        $updateData = [
            'title'       => 'Updated Task',
            'description' => 'Updated description',
            'due_date'    => now(),
            'status'      => Task::STATUS_IN_PROGRESS,
            'category_id' => 2,
            'priority'    => Task::PRIORITY_HIGH,
        ];

        $updatedTask = $this->taskRepository->update($task->id, $updateData);

        $this->assertEquals('Updated Task', $updatedTask->title);
        $this->assertEquals('Updated description', $updatedTask->description);
        $this->assertEquals(Task::STATUS_IN_PROGRESS, $updatedTask->status);
        $this->assertEquals(2, $updatedTask->category_id);
        $this->assertEquals(Task::PRIORITY_HIGH, $updatedTask->priority);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $this->taskRepository->delete($task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_filter_tasks()
    {
        Task::factory()->create(['status' => Task::STATUS_PENDING]);
        Task::factory()->create(['status' => Task::STATUS_IN_PROGRESS]);
        Task::factory()->create(['status' => Task::STATUS_COMPLETED]);

        $criteria = ['status' => Task::STATUS_IN_PROGRESS];
        $tasks = $this->taskRepository->filter($criteria);

        $this->assertCount(1, $tasks);
        $this->assertEquals(Task::STATUS_IN_PROGRESS, $tasks->first()->status);
    }

    public function test_filter_tasks_by_category_and_priority()
    {
        Task::factory()->create(['category_id' => 1, 'priority' => Task::PRIORITY_NORMAL]);
        Task::factory()->create(['category_id' => 1, 'priority' => Task::PRIORITY_HIGH]);
        Task::factory()->create(['category_id' => 2, 'priority' => Task::PRIORITY_NORMAL]);

        $criteria = ['category_id' => 1, 'priority' => Task::PRIORITY_HIGH];
        $tasks = $this->taskRepository->filter($criteria);

        $this->assertCount(1, $tasks);
        $this->assertEquals(1, $tasks->first()->category_id);
        $this->assertEquals(Task::PRIORITY_HIGH, $tasks->first()->priority);
    }
}

