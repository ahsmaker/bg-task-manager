<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date'    => $this->faker->dateTime,
            'status'      => $this->faker->numberBetween(0, 2),
            'category_id' => TaskCategory::factory(),
            'priority'    => $this->faker->numberBetween(0, 1),
        ];
    }
}
