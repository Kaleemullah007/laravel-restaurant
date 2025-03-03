<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->sequence(
            ['name' => 'superadmin'],
            ['name' => 'owner'],
            ['name' => 'manager'], ['name' => 'user'], ['name' => 'customer'])
            ->count(5)
            ->hasPermissions(Permission::factory()->count(5))
            ->create();
    }
}
