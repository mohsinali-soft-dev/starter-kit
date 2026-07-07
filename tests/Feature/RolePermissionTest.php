<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_super_admin_can_create_update_and_delete_roles_and_permissions(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin);

        $createPermission = $this->post(route('admin.permissions.store'), [
            'name' => 'reports.view',
            'group_name' => 'reports',
        ]);

        $createPermission->assertRedirect(route('admin.permissions.index'));

        $permission = Permission::query()->where('name', 'reports.view')->firstOrFail();

        $this->put(route('admin.permissions.update', $permission), [
            'name' => 'reports.export',
            'group_name' => 'reports',
        ])->assertRedirect(route('admin.permissions.index'));

        $updatedPermission = Permission::query()->where('name', 'reports.export')->firstOrFail();

        $this->post(route('admin.roles.store'), [
            'name' => 'support',
            'permissions' => [
                Permission::query()->where('name', 'dashboard.view')->value('id'),
                $updatedPermission->id,
            ],
        ])->assertRedirect(route('admin.roles.index'));

        $role = Role::query()->where('name', 'support')->firstOrFail();
        $this->assertTrue($role->permissions()->where('permissions.id', $updatedPermission->id)->exists());

        $this->put(route('admin.roles.update', $role), [
            'name' => 'support_team',
            'permissions' => [Permission::query()->where('name', 'dashboard.view')->value('id')],
        ])->assertRedirect(route('admin.roles.index'));

        $renamedRole = Role::query()->where('name', 'support_team')->firstOrFail();
        $this->assertTrue($renamedRole->permissions()->where('permissions.name', 'dashboard.view')->exists());

        $this->delete(route('admin.permissions.destroy', $updatedPermission))->assertRedirect(route('admin.permissions.index'));
        $this->assertDatabaseMissing('permissions', ['name' => 'reports.export']);

        $this->delete(route('admin.roles.destroy', $renamedRole))->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseMissing('roles', ['name' => 'support_team']);
    }
}
