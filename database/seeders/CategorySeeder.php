<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_list = [
            ['name' => 'Service', 'type' => 1, 'critical_deviation' => '1'],
            ['name' => 'Food', 'type' => 1, 'critical_deviation' => '2'],
            ['name' => 'Production Process', 'type' => 1, 'critical_deviation' => ''],
            ['name' => 'Cleanliness & Condition', 'type' => 1, 'critical_deviation' => '3'],
            ['name' => 'Document', 'type' => 1, 'critical_deviation' => ''],
            ['name' => 'People', 'type' => 1, 'critical_deviation' => ''],
            ['name' => 'Service', 'type' => 0, 'critical_deviation' => ''],
            ['name' => 'Food', 'type' => 0, 'critical_deviation' => ''],
            ['name' => 'Production Process', 'type' => 0, 'critical_deviation' => ''],
            ['name' => 'Cleanliness & Condition', 'type' => 0, 'critical_deviation' => ''],
            ['name' => 'Document', 'type' => 0, 'critical_deviation' => ''],
            ['name' => 'People', 'type' => 0, 'critical_deviation' => ''],
        ];
        foreach ($category_list as $category) {
            Category::create([
                'name' => $category['name'],
                'type' => $category['type'],
                'critical_deviation' => $category['critical_deviation'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
