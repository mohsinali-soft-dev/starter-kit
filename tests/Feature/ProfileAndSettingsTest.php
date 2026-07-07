<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_user_can_update_profile_password_and_delete_account(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $this->put(route('profile.update'), [
            'name' => 'Profile Updated',
            'email' => 'profile-updated@example.com',
            'avatar' => UploadedFile::fake()->image('profile.jpg'),
        ])->assertSessionHas('success');

        $profile = $user->fresh();
        $this->assertSame('Profile Updated', $profile->name);
        $this->assertSame('profile-updated@example.com', $profile->email);
        $this->assertNotNull($profile->avatar_path);

        $this->put(route('profile.password'), [
            'current_password' => 'password123',
            'password' => 'password456',
            'password_confirmation' => 'password456',
        ])->assertSessionHas('success');

        $this->assertTrue(Hash::check('password456', $profile->fresh()->password));

        $this->delete(route('profile.destroy'), [
            'password' => 'password456',
        ])->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertSoftDeleted('users', ['email' => 'profile-updated@example.com']);
    }

    public function test_admin_can_update_settings_and_helper_reads_them(): void
    {
        Storage::fake('public');

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin);

        $this->put(route('admin.settings.update'), [
            'site_name' => 'Starter Kit Pro',
            'currency' => 'EUR',
            'timezone' => 'Europe/London',
            'contact_email' => 'hello@starterkit.test',
            'logo' => UploadedFile::fake()->image('logo.png'),
            'favicon' => UploadedFile::fake()->image('favicon.png'),
        ])->assertSessionHas('success');

        $this->assertSame('Starter Kit Pro', setting('site_name'));
        $this->assertSame('EUR', setting('currency'));
        $this->assertSame('Europe/London', setting('timezone'));
        $this->assertSame('hello@starterkit.test', setting('contact_email'));
    }
}
