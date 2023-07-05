<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SanitaryModel;

class SanitarySeeder extends Seeder
{  /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
    {
        $sanitaryDefects = [
            ['code' => 'SD1', 'title' => 'Flies'],
            ['code' => 'SD2a', 'title' => 'Eggshell'],
            ['code' => 'SD2b', 'title' => 'Brush Bristle'],
            ['code' => 'SD3', 'title' => 'Worm'],
            ['code' => 'SD4', 'title' => 'Rat'],
            ['code' => 'SD5', 'title' => 'Lizard'],
            ['code' => 'SD6a', 'title' => 'Weevils'],
            ['code' => 'SD6b', 'title' => 'Bugs'],
            ['code' => 'SD6c', 'title' => 'Termites'],
            ['code' => 'SD6d', 'title' => 'Mosquitos'],
            ['code' => 'SD6e', 'title' => 'Spider'],
            ['code' => 'SD6f', 'title' => 'Unidentified Insects'],
            ['code' => 'SD6g', 'title' => 'Ants'],
            ['code' => 'SD6h', 'title' => 'Fruitfly'],
            ['code' => 'SD7', 'title' => 'Cockroach'],
            ['code' => 'SD8', 'title' => 'Slime / Molds'],
            ['code' => 'SD9', 'title' => 'Broken Glass'],
            ['code' => 'SD10', 'title' => 'Metal Pins'],
            ['code' => 'SD11a', 'title' => 'Hard Plastic'],
            ['code' => 'SD11b', 'title' => 'Soft Plastic'],
            ['code' => 'SD12', 'title' => 'Wood'],
            ['code' => 'SD13', 'title' => 'Hair Strands'],
            ['code' => 'SD14', 'title' => 'Feather (except those chicken)'],
            ['code' => 'SD15', 'title' => 'Paper'],
            ['code' => 'SD16', 'title' => 'Cigarette Butts'],
            ['code' => 'SD17', 'title' => 'Fishbone / Meatbone'],
            ['code' => 'SD18', 'title' => 'Unidentified Foreign Object (UFO) / Others'],
            ['code' => 'SD19', 'title' => 'Steel Wool / Scrubbing Pad'],
            ['code' => 'SD20', 'title' => 'Thread'],
            ['code' => 'SD21', 'title' => 'Black Soot Particles'],
            ['code' => 'SD22', 'title' => 'Stones']
        ];
        foreach ($sanitaryDefects as $defect) {
            SanitaryModel::create([
                'code' => $defect['code'],
                'title' => $defect['title'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
