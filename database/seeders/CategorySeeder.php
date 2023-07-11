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
            ['name' => 'Service', 'order' => 1,'type' => 1, 'critical_deviation_id' => 1],
            ['name' => 'Food', 'order' => 2, 'type' => 1, 'critical_deviation_id' => 2],
            ['name' => 'Production Process', 'order' => 3, 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'Cleanliness', 'order' => 4, 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'Condition', 'order' => 5, 'type' => 1, 'critical_deviation_id' => 3],
            ['name' => 'Document', 'order' => 6, 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'People', 'order' => 7, 'type' => 1, 'critical_deviation_id' => null],
            ['name' => 'Service',  'order' => 1,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Food',  'order' => 2,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Production Process',  'order' => 3,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Cleanliness',  'order' => 4,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Condition',  'order' => 5,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'Document',  'order' => 6,'type' => 0, 'critical_deviation_id' => null],
            ['name' => 'People',  'order' => 7,'type' => 0, 'critical_deviation_id' => null],
        ];
        foreach ($category_list as $category) {
            Category::create([
                'name' => $category['name'],
                'type' => $category['type'],
                'order' => $category['order'],
                'ros' => 0,
                'critical_deviation_id' => $category['critical_deviation_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
