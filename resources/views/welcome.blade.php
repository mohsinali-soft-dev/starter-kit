<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('site_name', config('app.name')) }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="auth-shell">
    <main class="min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-7">
                    <div class="glass-card p-4 p-lg-5">
                        <span class="badge badge-soft-primary rounded-pill px-3 py-2 mb-3">Laravel 13 starter kit</span>
                        <h1 class="display-4 fw-bold admin-page-title">A clean admin foundation for auth, users, roles, profile, and settings.</h1>
                        <p class="lead text-secondary mt-3">Bootstrap 5, email verification, password resets, role-based access control, and reusable Blade components are already wired in.</p>
                        <div class="d-flex gap-3 flex-wrap mt-4">
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg"><i class="bi bi-speedometer2 me-2"></i>Open dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Create account</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="panel-card hero-surface">
                        <h2 class="h4 fw-bold mb-3">Included modules</h2>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent px-0"><i class="bi bi-shield-lock me-2 text-primary"></i>Authentication and email verification</div>
                            <div class="list-group-item bg-transparent px-0"><i class="bi bi-people me-2 text-primary"></i>User management with search and filters</div>
                            <div class="list-group-item bg-transparent px-0"><i class="bi bi-shield-check me-2 text-primary"></i>Spatie roles and permissions</div>
                            <div class="list-group-item bg-transparent px-0"><i class="bi bi-person-badge me-2 text-primary"></i>Profile, avatar, password, and sessions</div>
                            <div class="list-group-item bg-transparent px-0"><i class="bi bi-sliders me-2 text-primary"></i>Database-backed settings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
