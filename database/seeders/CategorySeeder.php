<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $category_list = [
            ['name' => 'Service', 'type' => 1, 'critical_deviation_id' => 1],
            ['name' => 'Food', 'type' => 1, 'critical_deviation_id' => 2],
            ['name' => 'Production Process', 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'Cleanliness & Condition', 'type' => 1, 'critical_deviation_id' => 3],
            ['name' => 'Document', 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'People', 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'Service', 'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Food', 'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Production Process', 'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Cleanliness & Condition', 'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Document', 'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'People', 'type' => 0, 'critical_deviation_id' => null],
        ];
        foreach ($category_list as $category) {
            Category::create([
                'name' => $category['name'],
                'type' => $category['type'],
                'critical_deviation_id' => $category['critical_deviation_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
