<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkUserActionRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request): View
    {
        $users = User::query()
            ->with('roles')
            ->when($request->string('search')->toString(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->boolean('status')))
            ->when($request->filled('role'), function ($query) use ($request): void {
                $query->whereHas('roles', fn ($query) => $query->whereKey($request->integer('role')));
            })
            ->when($request->string('trashed')->toString() === 'with', fn ($query) => $query->withTrashed())
            ->when($request->string('trashed')->toString() === 'only', fn ($query) => $query->onlyTrashed())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        $this->syncUserRoles($user, $request);
        $this->syncAvatar($user, $request);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->forceFill([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'is_active' => $request->boolean('is_active', false),
            'email_verified_at' => now(),
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();

        $this->syncUserRoles($user, $request);
        $this->syncAvatar($user, $request);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function restore(int $user): RedirectResponse
    {
        $user = User::query()->withTrashed()->findOrFail($user);

        $this->authorize('restore', $user);

        $user->restore();

        return redirect()->route('admin.users.index', ['trashed' => 'with'])->with('success', 'User restored successfully.');
    }

    public function forceDelete(int $user): RedirectResponse
    {
        $user = User::query()->withTrashed()->findOrFail($user);

        $this->authorize('forceDelete', $user);

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->forceDelete();

        return redirect()->route('admin.users.index', ['trashed' => 'only'])->with('success', 'User permanently deleted.');
    }

    public function status(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->forceFill(['is_active' => ! $user->is_active])->save();

        return back()->with('success', 'User status updated.');
    }

    public function bulk(BulkUserActionRequest $request): RedirectResponse
    {
        $users = User::query()
            ->withTrashed()
            ->whereKey($request->validated('users'))
            ->get();

        match ($request->validated('action')) {
            'activate' => $this->bulkUpdateStatus($users, true),
            'deactivate' => $this->bulkUpdateStatus($users, false),
            'delete' => $this->bulkDelete($users),
            'restore' => $this->bulkRestore($users),
            'force_delete' => $this->bulkForceDelete($users),
        };

        return back()->with('success', 'Bulk action completed successfully.');
    }

    private function syncUserRoles(User $user, UserRequest $request): void
    {
        $roleIds = collect($request->validated('roles', []))
            ->filter()
            ->map(fn ($roleId) => (int) $roleId)
            ->all();

        if ($roleIds === [] && Role::query()->where('name', 'user')->exists()) {
            $roleIds = [Role::query()->where('name', 'user')->value('id')];
        }

        $user->syncRoles($roleIds);
    }

    private function syncAvatar(User $user, UserRequest $request): void
    {
        if (! $request->hasFile('avatar')) {
            return;
        }

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->forceFill([
            'avatar_path' => $request->file('avatar')->store('avatars', 'public'),
        ])->save();
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function bulkUpdateStatus(Collection $users, bool $isActive): void
    {
        $users->each(function (User $user) use ($isActive): void {
            $this->authorize('update', $user);

            if (! $user->trashed()) {
                $user->forceFill(['is_active' => $isActive])->save();
            }
        });
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function bulkDelete(Collection $users): void
    {
        $users->each(function (User $user): void {
            $this->authorize('delete', $user);

            if (! $user->trashed()) {
                $user->delete();
            }
        });
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function bulkRestore(Collection $users): void
    {
        $users->each(function (User $user): void {
            $this->authorize('restore', $user);

            if ($user->trashed()) {
                $user->restore();
            }
        });
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function bulkForceDelete(Collection $users): void
    {
        $users->each(function (User $user): void {
            $this->authorize('forceDelete', $user);

            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $user->forceDelete();
        });
    }
}
