<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dropdown;

class DropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dropdown_list = [
            ['name' => 'Food Apperance'],
            ['name' => 'Food Texture'],
            ['name' => 'Food Taste'],
            ['name' => 'Food Temp'],
            ['name' => 'Food Espresso Apprearance'],
            ['name' => 'Food Creama'],
            ['name' => 'Food Espresso Taste'],
            ['name' => 'Production Process T&U and Equipment'],
            ['name' => 'Production Process In Process pre-prep'],
            ['name' => 'Production Process In Process Brewing'],
            ['name' => 'Production Process In Process Steaming & Reheating'],
            ['name' => 'Production Process In Process  Staging'],
            ['name' => 'Production Process In Process Assembly'],
            ['name' => 'Service CD Customer Complaint'], //14
            ['name' => 'Service CD Dinning Temperature'],
            ['name' => 'Service CD Background Music'],
            ['name' => 'CD Location'],
            ['name' => 'CD Products'],
        ];
        foreach ($dropdown_list as $dropdown) {
            Dropdown::create([
                'name' => $dropdown['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
