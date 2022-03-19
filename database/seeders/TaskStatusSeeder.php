<?php

namespace Database\Seeders;

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
        $statuses = [
            ['name' => 'новый', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'в работе', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'на тестировании', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'завершен', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('task_statuses')->insert($statuses);
    }
}
