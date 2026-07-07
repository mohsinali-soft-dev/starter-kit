@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Permissions']])

<x-layouts.admin title="Permissions" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="h5 mb-1">Permissions</h2>
                <p class="text-secondary mb-0">Organize permissions by group for easier management.</p>
            </div>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">New permission</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Group</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td class="fw-semibold">{{ $permission->name }}</td>
                            <td><span class="badge badge-soft-primary rounded-pill">{{ $permission->group_name ?: 'General' }}</span></td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Delete this permission?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
