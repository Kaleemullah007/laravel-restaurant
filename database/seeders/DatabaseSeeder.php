<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Plan;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            // PlanSeeder::class,
            // PermissionSeeder::class,
            // RoleSeeder::class,
            // ModuleSeeder::class,
            UserSeeder::class,
            VendorSeeder::class,
            CustomerSeeder::class,
            EmployeeSeeder::class,
            ProductSeeder::class,
            OrderStatusSeeder::class,
            OrderTypeSeeder::class,

        ]);

        // $plan = Plan::factory(1)->create();
        // $permissions = Permission::factory(10)->create();
        // $roles = Role::factory(10)->create();

    }
}
