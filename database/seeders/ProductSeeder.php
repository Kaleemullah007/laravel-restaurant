<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 4; $i++) {

            Product::factory()->count(1)->state(new Sequence([
                'product_code' => productCode(),
            ]))->create();
        }
    }
}
