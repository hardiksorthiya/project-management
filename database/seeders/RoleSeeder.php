<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $permissions = Permission::all();
    $admin->syncPermissions($permissions); // ✅ give all permissions
}
}
