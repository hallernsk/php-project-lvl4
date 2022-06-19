<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = TaskStatus::inRandomOrder()->first();
 //       dd($status);
        $user = User::inRandomOrder()->first();
        $performer = User::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'status_id' => $status->id,
            'description' => 'example description',
            'created_by_id' => $user->id,
            'assigned_to_id' => $performer->id
        ];
    }
}
