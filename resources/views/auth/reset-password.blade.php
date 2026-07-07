<x-layouts.auth
    title="Reset password"
    eyebrow="New credentials"
    heading="Create a stronger password."
    copy="Choose a password that protects your account and keeps your workspace data secure."
>
    <form action="{{ route('password.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="auth-heading mb-4">
            <p class="auth-kicker">Reset password</p>
            <h2>Create new password</h2>
            <p>Use at least 8 characters. A mix of letters and numbers is best.</p>
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <div class="input-shell">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', request('email')) }}" placeholder="you@example.com" autocomplete="email" required readonly>
            </div>
            @error('email')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">New password</label>
            <div class="input-shell">
                <i class="bi bi-lock" aria-hidden="true"></i>
                <input class="form-control" type="password" id="password" name="password" placeholder="Enter new password" autocomplete="new-password" required>
            </div>
            @error('password')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label" for="password_confirmation">Confirm password</label>
            <div class="input-shell">
                <i class="bi bi-shield-check" aria-hidden="true"></i>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" autocomplete="new-password" required>
            </div>
        </div>

        <button class="btn btn-primary w-100 btn-lg mb-4" type="submit">
            <i class="bi bi-check2-circle me-2"></i>Reset password
        </button>

        <a class="auth-back-link" href="{{ route('login') }}">
            <i class="bi bi-arrow-left me-2"></i>Back to sign in
        </a>
    </form>
</x-layouts.auth>
