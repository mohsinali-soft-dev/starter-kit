<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_super_admin_can_create_filter_update_and_delete_users(): void
    {
        Storage::fake('public');

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Managed User',
            'email' => 'managed@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
            'roles' => [Role::query()->where('name', 'user')->value('id'), Role::query()->where('name', 'admin')->value('id')],
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $createdUser = User::query()->where('email', 'managed@example.com')->firstOrFail();

        $this->assertTrue($createdUser->hasRole('user'));
        $this->assertTrue($createdUser->hasRole('admin'));
        Storage::disk('public')->assertExists($createdUser->avatar_path);

        $this->get(route('admin.users.index', ['search' => 'Managed']))
            ->assertOk()
            ->assertSee('Managed User');

        $this->put(route('admin.users.update', $createdUser), [
            'name' => 'Managed User Updated',
            'email' => 'managed-updated@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => false,
            'roles' => [Role::query()->where('name', 'user')->value('id')],
            'avatar' => UploadedFile::fake()->image('avatar-2.jpg'),
        ])->assertRedirect(route('admin.users.index'));

        $updatedUser = User::query()->where('email', 'managed-updated@example.com')->firstOrFail();
        $this->assertSame('Managed User Updated', $updatedUser->name);
        $this->assertFalse($updatedUser->is_active);

        $this->patch(route('admin.users.status', $updatedUser))->assertSessionHas('success');
        $this->assertTrue($updatedUser->fresh()->is_active);

        $this->delete(route('admin.users.destroy', $updatedUser))->assertRedirect(route('admin.users.index'));
        $this->assertSoftDeleted('users', ['email' => 'managed-updated@example.com']);

        $this->get(route('admin.users.index', ['trashed' => 'only']))
            ->assertOk()
            ->assertSee('Managed User Updated');

        $this->patch(route('admin.users.restore', $updatedUser->id))->assertRedirect(route('admin.users.index', ['trashed' => 'with']));
        $this->assertFalse($updatedUser->fresh()->trashed());

        $bulkUsers = User::factory()->count(2)->create(['is_active' => true]);
        $userRole = Role::query()->where('name', 'user')->firstOrFail();
        $bulkUsers->each->assignRole($userRole);

        $this->post(route('admin.users.bulk'), [
            'action' => 'deactivate',
            'users' => $bulkUsers->pluck('id')->all(),
        ])->assertSessionHas('success');

        $bulkUsers->each(fn (User $user) => $this->assertFalse($user->fresh()->is_active));

        $this->delete(route('admin.users.force-delete', $updatedUser->id))->assertRedirect(route('admin.users.index', ['trashed' => 'only']));
        $this->assertDatabaseMissing('users', ['email' => 'managed-updated@example.com']);
    }
}
