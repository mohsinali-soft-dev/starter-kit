@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Users']])

<x-layouts.admin title="Users" :breadcrumbs="$breadcrumbs">
    <div class="panel-card mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <x-form.input name="search" label="Search" :value="request('search')" placeholder="Search by name or email" />
            </div>
            <div class="col-12 col-md-3">
                <x-form.select name="status" label="Status" :value="request('status')" :options="['1' => 'Active', '0' => 'Inactive']" placeholder="All statuses" />
            </div>
            <div class="col-12 col-md-3">
                <x-form.select name="role" label="Role" :value="request('role')" :options="$roles->pluck('name', 'id')->all()" placeholder="All roles" />
            </div>
            <div class="col-12 col-md-2">
                <x-form.select name="trashed" label="Deleted" :value="request('trashed')" :options="['with' => 'With deleted', 'only' => 'Only deleted']" placeholder="Active only" />
            </div>
            <div class="col-12 col-md-12 d-grid d-md-flex justify-content-md-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light border">Reset</a>
                <button class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <div class="panel-card">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
            <div>
                <h2 class="h5 mb-1">User records</h2>
                <p class="text-secondary mb-0">Manage users, roles, and account status.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>New user</a>
        </div>

        <form method="POST" action="{{ route('admin.users.bulk') }}">
            @csrf

            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">
                <div class="d-flex gap-2">
                    <select name="action" class="form-select" aria-label="Bulk action">
                        <option value="">Bulk action</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Move to trash</option>
                        <option value="restore">Restore</option>
                        <option value="force_delete">Delete permanently</option>
                    </select>
                    <button class="btn btn-outline-primary" type="submit">Apply</button>
                </div>
            </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 42px;">
                            <input class="form-check-input" type="checkbox" aria-label="Select all users" onclick="document.querySelectorAll('[data-user-checkbox]').forEach((checkbox) => checkbox.checked = this.checked)">
                        </th>
                        <th>User</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th>Verified</th>
                        <th>Deleted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                @unless (auth()->user()->is($user))
                                    <input class="form-check-input" data-user-checkbox type="checkbox" name="users[]" value="{{ $user->id }}" aria-label="Select {{ $user->name }}">
                                @endunless
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img class="avatar-circle" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <div class="text-secondary small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        <span class="badge rounded-pill bg-light text-dark border">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-secondary">No roles</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <span class="badge rounded-pill {{ $user->email_verified_at ? 'badge-soft-success' : 'badge-soft-danger' }}">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</span>
                            </td>
                            <td>
                                <span class="badge rounded-pill {{ $user->trashed() ? 'badge-soft-danger' : 'badge-soft-success' }}">{{ $user->trashed() ? 'Deleted' : 'Active record' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    @if ($user->trashed())
                                        <button class="btn btn-sm btn-outline-success" type="submit" form="restore-user-{{ $user->id }}">Restore</button>
                                        <button class="btn btn-sm btn-outline-danger" type="submit" form="force-delete-user-{{ $user->id }}">Delete permanently</button>
                                    @else
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <button class="btn btn-sm btn-outline-secondary" type="submit" form="status-user-{{ $user->id }}">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                                        <button class="btn btn-sm btn-outline-danger" type="submit" form="delete-user-{{ $user->id }}">Delete</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-5">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </form>

        @foreach ($users as $user)
            @if ($user->trashed())
                <form id="restore-user-{{ $user->id }}" action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('PATCH')
                </form>
                <form id="force-delete-user-{{ $user->id }}" action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" class="d-none" onsubmit="return confirm('Permanently delete this user?')">
                    @csrf
                    @method('DELETE')
                </form>
            @else
                <form id="status-user-{{ $user->id }}" action="{{ route('admin.users.status', $user) }}" method="POST" class="d-none">
                    @csrf
                    @method('PATCH')
                </form>
                <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        @endforeach

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-layouts.admin>
