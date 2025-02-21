<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->count(2)->state(new Sequence(['user_type' => 'customer', 'name' => 'Walkin Customer'],
            ['user_type' => 'employee']))->create(['owner_id' => 1]);

    }
}
