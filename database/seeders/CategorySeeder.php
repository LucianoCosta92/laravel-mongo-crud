<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Estudos',
                'color' => '#3490dc',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Trabalho',
                'color' => '#38c172',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pessoal',
                'color' => '#ffed4a',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
