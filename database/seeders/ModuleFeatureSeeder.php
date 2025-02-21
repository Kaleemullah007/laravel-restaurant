<?php

namespace Database\Seeders;

use App\Models\ModuleFeature;
use Illuminate\Database\Seeder;

class ModuleFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModuleFeature::factory()->create();
    }
}
