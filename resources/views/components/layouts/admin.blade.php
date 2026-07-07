@props(['title' => config('app.name'), 'breadcrumbs' => []])

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
<body class="admin-shell">
    <div class="d-flex min-vh-100">
        <x-admin.sidebar />

        <div class="flex-grow-1 d-flex flex-column">
            <x-admin.topbar :title="$title" />

            <main class="flex-grow-1 p-3 p-lg-4">
                <x-flash-messages />
                <x-toasts />

                @if (count($breadcrumbs))
                    <x-admin.breadcrumbs :items="$breadcrumbs" class="mb-4" />
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toast').forEach((toast) => new bootstrap.Toast(toast).show());
    </script>
</body>
</html>
