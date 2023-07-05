<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DropdownMenu;

class DropdownMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dropdown_menu_list = [
            ['name' => 'Deformed', 'dropdown_id' => 1],
            ['name' => 'Burnt', 'dropdown_id' => 1],
            ['name' => 'Pale', 'dropdown_id' => 1],
            ['name' => 'With SD', 'dropdown_id' => 1],
            ['name' => 'Flasky', 'dropdown_id' => 2],
            ['name' => 'Dry', 'dropdown_id' => 2],
            ['name' => 'Bitter', 'dropdown_id' => 3],
            ['name' => 'Sour', 'dropdown_id' => 3],
            ['name' => 'Burning', 'dropdown_id' => 3],
            ['name' => 'Below 56°C', 'dropdown_id' => 4],
            ['name' => 'Above 60°C', 'dropdown_id' => 4],
            ['name' => 'Overportioned', 'dropdown_id' => 5],
            ['name' => 'Underportioned', 'dropdown_id' => 5],
            ['name' => 'With SD', 'dropdown_id' => 5],
            ['name' => 'Defective Utensils', 'dropdown_id' => 5],
            ['name' => 'Dark', 'dropdown_id' => 6],
            ['name' => 'Light', 'dropdown_id' => 6],
            ['name' => 'Thin', 'dropdown_id' => 6],
            ['name' => 'Sour', 'dropdown_id' => 6],
            ['name' => 'Thick', 'dropdown_id' => 7],
            ['name' => 'Bitter', 'dropdown_id' => 7],
            ['name' => 'Bland', 'dropdown_id' => 7],
            ['name' => 'Not Available', 'dropdown_id' => 8],
            ['name' => 'Not Calibrated', 'dropdown_id' => 8],
            ['name' => 'Not in Use', 'dropdown_id' => 8],
            ['name' => 'Too Coarse', 'dropdown_id' => 9],
            ['name' => 'Too Fine', 'dropdown_id' => 9],
            ['name' => 'Under Extracted', 'dropdown_id' => 10],
            ['name' => 'Over Extracted', 'dropdown_id' => 10],
            ['name' => 'Incorrect Heating Procedure/Time/Temperature', 'dropdown_id' => 11],
            ['name' => 'Underportioned', 'dropdown_id' => 11],
            ['name' => 'Overportioned', 'dropdown_id' => 11],
            ['name' => 'No Label/Tag', 'dropdown_id' => 12],
            ['name' => 'Improper Label/Tag', 'dropdown_id' => 12],
            ['name' => 'Beyond Secondary Shelf-Life', 'dropdown_id' => 12],
            ['name' => 'Underportioned', 'dropdown_id' => 13],
            ['name' => 'Overportioned', 'dropdown_id' => 13],
            ['name' => 'Incorrect Ingredients', 'dropdown_id' => 13],
            ['name' => 'Incomplete Components/', 'dropdown_id' => 13],
            ['name' => 'Food Related', 'dropdown_id' => 14],
            ['name' => 'Service Related', 'dropdown_id' => 14],
            ['name' => 'Ambiance Related', 'dropdown_id' => 14],
            ['name' => 'Others', 'dropdown_id' => 14],
            ['name' => '<21°C', 'dropdown_id' => 15],
            ['name' => '>25°C', 'dropdown_id' => 15],
            ['name' => 'No Music', 'dropdown_id' => 16],
            ['name' => 'Too Soft', 'dropdown_id' => 16],
            ['name' => 'Too Loud', 'dropdown_id' => 16],
            ['name' => 'Unapproved Playlist', 'dropdown_id' => 16],
            ['name' => 'Food', 'dropdown_id' => 17],
            ['name' => 'Packaging', 'dropdown_id' => 17],
            ['name' => 'Equipment ', 'dropdown_id' => 17],
            ['name' => 'Dinning Area ', 'dropdown_id' => 17],
            ['name' => 'Other Rooms ', 'dropdown_id' => 17],
            ['name' => 'Baked Goods ', 'dropdown_id' => 18],
            ['name' => 'Salad', 'dropdown_id' => 18],
            ['name' => 'Appetizer ', 'dropdown_id' => 18],
            ['name' => 'Pasta ', 'dropdown_id' => 18],
            ['name' => 'Pizza ', 'dropdown_id' => 18],
            ['name' => 'Rice Meal ', 'dropdown_id' => 18],
            ['name' => 'Sandwich ', 'dropdown_id' => 18],
            ['name' => 'Mains ', 'dropdown_id' => 18],
            ['name' => 'Drinks ', 'dropdown_id' => 18],
        ];
        foreach ($dropdown_menu_list as $dropdown_menu) {
            DropdownMenu::create([
                'name' => $dropdown_menu['name'],
                'dropdown_id' => $dropdown_menu['dropdown_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}