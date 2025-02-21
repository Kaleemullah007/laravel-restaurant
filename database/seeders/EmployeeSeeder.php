<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->count(4)->state(new Sequence(
            ['user_type' => 'employee', 'email' => 'employee@rktech.com'],
            ['user_type' => 'admin', 'email' => 'admin@rktech.com'],
            ['user_type' => 'admin', 'email' => 'tester@rktech.com', 'is_tester' => true],
            ['user_type' => 'superadmin', 'email' => 'superadmin@rktech.com']))
            ->create(['owner_id' => null]);
    }
}
