<aside class="offcanvas-lg offcanvas-start admin-sidebar" tabindex="-1" id="adminSidebar">
    <div class="offcanvas-header d-lg-none border-bottom border-light border-opacity-10">
        <h5 class="offcanvas-title text-white mb-0">{{ setting('site_name', config('app.name')) }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-4">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-3 text-white mb-4">
            <div class="rounded-4 bg-white bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                <i class="bi bi-grid-1x2-fill fs-5"></i>
            </div>
            <div>
                <div class="fw-bold">{{ setting('site_name', config('app.name')) }}</div>
                <div class="small text-white-50">Admin panel</div>
            </div>
        </a>

        <nav class="nav nav-pills flex-column gap-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people me-2"></i>Users
            </a>
            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                <i class="bi bi-shield-check me-2"></i>Roles
            </a>
            <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                <i class="bi bi-key me-2"></i>Permissions
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                <i class="bi bi-sliders me-2"></i>Settings
            </a>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="bi bi-person-badge me-2"></i>Profile
            </a>
        </nav>

        <div class="mt-auto pt-4 small text-white-50">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-check2-circle text-info"></i>
                <span>Laravel 13 ready</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-bootstrap-fill text-warning"></i>
                <span>Bootstrap 5 layout</span>
            </div>
        </div>
    </div>
</aside>
