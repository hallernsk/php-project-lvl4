<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [];
        $statusNames = ['новый', 'в работе', 'на тестировании', 'завершен'];
        foreach ($statusNames as $name) {
     //       $statuses[] = ['name' => $name, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            TaskStatus::factory()->create(['name' => $name]);
        }
//        DB::table('task_statuses')->insert($statuses);
    }
}
