<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([UserSeeder::class]);
        $this->call([SanitarySeeder::class]);
        $this->call([DropdownSeeder::class]);
        $this->call([DropdownMenuSeeder::class]);
        $this->call([CriticalDeviationSeeder::class]);
        $this->call([CriticalDeviationLabelSeeder::class]);
        $this->call([CategorySeeder::class]);
        $this->call([SubCategorySeeder::class]);
        $this->call([SubCategoryLabelSeeder::class]);
        $this->call([StoreSeeder::class]);
        $this->call([AuditTemplateSeeder::class]);
    }
}
