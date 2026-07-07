<x-layouts.auth
    title="Sign in"
    eyebrow="Secure workspace"
    heading="Welcome back."
    copy="Sign in to manage users, reviews, roles, permissions, and customer operations from one polished dashboard."
>
    <form action="{{ route('login.store') }}" method="POST" novalidate>
        @csrf

        <div class="auth-heading mb-4">
            <p class="auth-kicker">Account access</p>
            <h2>Sign in to your account</h2>
            <p>Use your workspace credentials to continue.</p>
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <div class="input-shell">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
            </div>
            @error('email')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between gap-3">
                <label class="form-label" for="password">Password</label>
                <a class="small fw-semibold" href="{{ route('password.request') }}">Forgot password?</a>
            </div>
            <div class="input-shell">
                <i class="bi bi-lock" aria-hidden="true"></i>
                <input class="form-control" type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
            </div>
            @error('password')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <label class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                <span class="form-check-label">Remember me</span>
            </label>
            <a class="small fw-semibold" href="{{ route('register') }}">Create an account</a>
        </div>

        <button class="btn btn-primary w-100 btn-lg" type="submit">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
        </button>
    </form>
</x-layouts.auth>
