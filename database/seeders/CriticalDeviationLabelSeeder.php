<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CriticalDeviationMenu;

class CriticalDeviationLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $critical_deviation_label = [
            [
                'critical_deviation_id' => 1,
                'label' => 'Customer Complaint',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => 1,
                'dropdown_id' => 14,
            ],
            [
                'critical_deviation_id' => 1,
                'label' => 'Product Availability (Less 3% for non flagship and 5% for flagship/core products)',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => null,
                'dropdown_id' => null,
            ],
            [
                'critical_deviation_id' => 1,
                'label' => 'Dining Temperature',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => 1,
                'dropdown_id' => 15,
            ],
            [
                'critical_deviation_id' => 1,
                'label' => 'Background Music',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => 1,
                'dropdown_id' => 16,
            ],
            [
                'critical_deviation_id' => 2,
                'label' => 'Less Critical & Major SD',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => 1,
                'is_location' => 1,
                'location_dropdown_id' => 17,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => null,
                'dropdown_id' => null,
            ],
            [
                'critical_deviation_id' => 2,
                'label' => 'Less Spoiled/Lapsed product',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => 1,
                'product_dropdown_id' => 18,
                'is_dropdown' => null,
                'dropdown_id' => null,
            ],
            [
                'critical_deviation_id' => 3,
                'label' => 'Less Critical Deviations: Strong Foul Odor',
                'remarks' => 1,
                'score_dropdown_id' => null,
                'is_sd' => null,
                'is_location' => null,
                'location_dropdown_id' => null,
                'is_product' => null,
                'product_dropdown_id' => null,
                'is_dropdown' => null,
                'dropdown_id' => null,
            ],
        ];
        foreach ($critical_deviation_label as $deviation) {
            CriticalDeviationMenu::create([
                'critical_deviation_id' => $deviation['critical_deviation_id'],
                'label' => $deviation['name'],
                'remarks' => $deviation['remarks'],
                'score_dropdown_id' => $deviation['score_dropdown_id'],
                'is_sd' => $deviation['is_sd'],
                'is_location' => $deviation['is_location'],
                'location_dropdown_id' => $deviation['location_dropdown_id'],
                'is_product' => $deviation['is_product'],
                'product_dropdown_id' => $deviation['product_dropdown_id'],
                'is_dropdown' => $deviation['is_dropdown'],
                'dropdown_id' => $deviation['dropdown_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}