@php($breadcrumbs = [['label' => 'Dashboard']])

<x-layouts.admin title="Dashboard" :breadcrumbs="$breadcrumbs">
    <x-admin.page-header
        title="Dashboard"
        subtitle="A quick overview of the starter kit foundation."
    >
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Open site</a>
    </x-admin.page-header>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="metric-card">
                <div class="text-secondary small text-uppercase fw-semibold">Users</div>
                <div class="display-6 fw-bold mb-0">{{ $userCount }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="metric-card">
                <div class="text-secondary small text-uppercase fw-semibold">Active users</div>
                <div class="display-6 fw-bold mb-0">{{ $activeUserCount }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="metric-card">
                <div class="text-secondary small text-uppercase fw-semibold">Roles</div>
                <div class="display-6 fw-bold mb-0">{{ $roleCount }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="metric-card">
                <div class="text-secondary small text-uppercase fw-semibold">Permissions</div>
                <div class="display-6 fw-bold mb-0">{{ $permissionCount }}</div>
            </div>
        </div>
    </div>

    <div class="panel-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="h5 mb-1">Recent users</h2>
                <p class="text-secondary mb-0">A quick look at newly created accounts.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">View all</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end text-secondary">{{ $user->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
