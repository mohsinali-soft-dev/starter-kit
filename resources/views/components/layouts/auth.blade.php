@props([
    'title' => config('app.name'),
    'eyebrow' => 'Workspace platform',
    'heading' => 'A professional dashboard foundation.',
    'copy' => 'Manage accounts, permissions, profile settings, and operational workflows with a clean responsive interface.',
])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ setting('site_name', config('app.name')) }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="auth-shell">
    <main class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100">
                <aside class="col-lg-6 d-none d-lg-flex auth-showcase">
                    <div class="auth-showcase-inner">
                        <a href="{{ route('home') }}" class="brand-lockup text-white">
                            <span class="brand-mark"><i class="bi bi-shield-lock-fill"></i></span>
                            <span>{{ setting('site_name', config('app.name')) }}</span>
                        </a>

                        <div class="auth-copy">
                            <p class="auth-showcase-eyebrow">{{ $eyebrow }}</p>
                            <h1>{{ $heading }}</h1>
                            <p>{{ $copy }}</p>
                        </div>

                        <div class="auth-proof-grid">
                            <div>
                                <span>3</span>
                                <p>Core roles seeded</p>
                            </div>
                            <div>
                                <span>9</span>
                                <p>Permissions ready</p>
                            </div>
                            <div>
                                <span>100%</span>
                                <p>Responsive views</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="col-12 col-lg-6 auth-form-panel">
                    <div class="auth-mobile-brand">
                        <a href="{{ route('home') }}" class="brand-lockup">
                            <span class="brand-mark"><i class="bi bi-shield-lock-fill"></i></span>
                            <span>{{ setting('site_name', config('app.name')) }}</span>
                        </a>
                    </div>

                    <div class="auth-card">
                        <x-flash-messages />
                        <x-toasts />
                        {{ $slot }}
                    </div>

                    <footer class="auth-footer">
                        <span>&copy; {{ now()->year }} {{ setting('site_name', config('app.name')) }}</span>
                        <nav>
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('login') }}">Login</a>
                        </nav>
                    </footer>
                </section>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toast').forEach((toast) => new bootstrap.Toast(toast).show());
    </script>
</body>
</html>
