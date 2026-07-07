<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAdminSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'roles' => ['super_admin', 'admin'],
            ],
            [
                'name' => 'Reviewer User',
                'email' => 'reviewer@example.com',
                'roles' => ['reviewer'],
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'roles' => ['customer', 'user'],
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );

            $roles = Role::query()
                ->whereIn('name', $account['roles'])
                ->pluck('name')
                ->all();

            if ($roles !== []) {
                $user->syncRoles($roles);
            }
        }
    }
}
