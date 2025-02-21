<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::factory()->count(3)->state(new Sequence(
            [
                'name' => 'Delivery',
                'owner_id' => 1,

            ],
            [
                'name' => 'Takeway',
                'owner_id' => 1,

            ],
            [
                'name' => 'DineIn',
                'owner_id' => 1,
            ],
        ))->create();
    }
}
