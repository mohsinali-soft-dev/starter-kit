<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard.view' => 'dashboard',
            'users.view' => 'users',
            'users.create' => 'users',
            'users.update' => 'users',
            'users.delete' => 'users',
            'roles.manage' => 'roles',
            'permissions.manage' => 'permissions',
            'settings.manage' => 'settings',
            'profile.manage' => 'profile',
        ];

        foreach ($permissions as $name => $group) {
            Permission::query()->updateOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['group_name' => $group]
            );
        }

        $superAdmin = Role::query()->updateOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::query()->updateOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $reviewer = Role::query()->updateOrCreate(['name' => 'reviewer', 'guard_name' => 'web']);
        $customer = Role::query()->updateOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $user = Role::query()->updateOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $allPermissionIds = Permission::query()->pluck('id');

        $superAdmin->syncPermissions($allPermissionIds);
        $admin->syncPermissions($allPermissionIds);
        $reviewer->syncPermissions(Permission::query()->whereIn('name', [
            'dashboard.view',
            'users.view',
            'profile.manage',
        ])->pluck('id'));
        $customer->syncPermissions(Permission::query()->whereIn('name', [
            'dashboard.view',
            'profile.manage',
        ])->pluck('id'));
        $user->syncPermissions(Permission::query()->whereIn('name', ['dashboard.view', 'profile.manage'])->pluck('id'));
    }
}
