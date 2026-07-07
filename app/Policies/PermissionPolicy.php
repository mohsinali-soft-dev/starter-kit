<?php

namespace App\Policies;

use App\Models\User;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('permissions.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('permissions.manage');
    }

    public function update(User $user): bool
    {
        return $user->can('permissions.manage');
    }

    public function delete(User $user): bool
    {
        return $user->can('permissions.manage');
    }
}
