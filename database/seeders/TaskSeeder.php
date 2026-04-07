<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::insert([
            [
                'title' => 'Estudar Laravel',
                'description' => 'Aprender MongoDB com Laravel',
                'status' => 'pending',
                'priority' => 'high',
                'tags' => ['backend', 'php'],
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
