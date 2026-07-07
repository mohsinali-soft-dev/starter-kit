@props(['title' => null])

<header class="admin-topbar navbar navbar-expand-lg sticky-top">
    <div class="container-fluid px-3 px-lg-4 py-2">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="small text-secondary text-uppercase fw-semibold">{{ setting('site_name', config('app.name')) }}</div>
                <h1 class="h4 mb-0 admin-page-title">{{ $title }}</h1>
            </div>
        </div>

        <div class="ms-auto d-flex align-items-center gap-3">
            <a class="btn btn-light border" href="{{ route('home') }}">
                <i class="bi bi-house-door me-1"></i>Home
            </a>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="avatar-circle me-2" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
