<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        SubCategory::create(['name' => 'Speed and Accuracy', 'is_sub' => 1, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()]);
    }
}