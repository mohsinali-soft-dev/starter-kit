<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => config('app.name'), 'group' => 'general', 'type' => 'text', 'label' => 'Site name', 'is_public' => true],
            ['key' => 'logo', 'value' => null, 'group' => 'branding', 'type' => 'image', 'label' => 'Logo', 'is_public' => true],
            ['key' => 'favicon', 'value' => null, 'group' => 'branding', 'type' => 'image', 'label' => 'Favicon', 'is_public' => true],
            ['key' => 'currency', 'value' => 'USD', 'group' => 'localization', 'type' => 'text', 'label' => 'Currency', 'is_public' => true],
            ['key' => 'timezone', 'value' => config('app.timezone', 'UTC'), 'group' => 'localization', 'type' => 'text', 'label' => 'Timezone', 'is_public' => true],
            ['key' => 'contact_email', 'value' => env('MAIL_FROM_ADDRESS', 'hello@example.com'), 'group' => 'general', 'type' => 'email', 'label' => 'Contact email', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
