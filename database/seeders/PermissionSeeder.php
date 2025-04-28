<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $groups = [
            'user' => [
                'user.view',
                'user.create',
                'user.update',
                'user.delete',
            ],
            'role' => [
                'role.view',
                'role.create',
                'role.update',
                'role.delete',
            ],
            'permission' => [
                'permission.view',
                'permission.create',
                'permission.update',
                'permission.delete',
            ],
        ];

        foreach ($groups as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::updateOrCreate([
                    'name' => $permission,
                    'group_name' => $group,
                ]);
            }
        }

         // ✅ Give all permissions to Admin Role
         $adminRole = Role::firstOrCreate(['name' => 'admin']);
         $adminRole->syncPermissions(Permission::all());
    }
}
