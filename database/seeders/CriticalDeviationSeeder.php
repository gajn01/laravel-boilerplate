<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CriticalDeviation;

class CriticalDeviationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $critical_deviation = [
            ['name' => 'Service'],
            ['name' => 'Food'],
            ['name' => 'Cleanliness & Condition'],
        ];
        foreach ($critical_deviation as $deviation) {
            CriticalDeviation::create([
                'name' => $deviation['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
