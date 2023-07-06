<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubCategoryLabel;

class SubCategoryLabelSeeder extends Seeder
{
    public function run(): void
    {
        SubCategoryLabel::create(
            ['name' => 'Cashier TAT', 'bp' => 0, 'is_all_nothing' => 0, 'sub_category_id' => 1, 'dropdown_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Server CAT', 'bp' => 0, 'is_all_nothing' => 0, 'sub_category_id' => 1, 'dropdown_id' => 0, 'created_at' => now(), 'updated_at' => now()],
        );
    }
}