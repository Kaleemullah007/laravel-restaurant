<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::factory()->count(4)->state(new Sequence(
            [
                'name' => 'Pending',
                'owner_id' => 1,

            ],
            [
                'name' => 'Completed',
                'owner_id' => 1,

            ],
            [
                'name' => 'Cancelled',
                'owner_id' => 1,
            ],
            [
                'name' => 'Rejected',
                'owner_id' => 1,
            ]

        ))->create();
    }
}
