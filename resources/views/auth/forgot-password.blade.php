<x-layouts.auth
    title="Forgot password"
    eyebrow="Password recovery"
    heading="Reset access with confidence."
    copy="We will email a secure reset link so the account owner can create a new password without administrator help."
>
    <form action="{{ route('password.email') }}" method="POST" novalidate>
        @csrf

        <div class="auth-heading mb-4">
            <p class="auth-kicker">Recover account</p>
            <h2>Forgot password?</h2>
            <p>Enter your email and we will send you a reset link.</p>
        </div>

        <div class="mb-4">
            <label class="form-label" for="email">Email address</label>
            <div class="input-shell">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
            </div>
            @error('email')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary w-100 btn-lg mb-4" type="submit">
            <i class="bi bi-send me-2"></i>Send reset link
        </button>

        <a class="auth-back-link" href="{{ route('login') }}">
            <i class="bi bi-arrow-left me-2"></i>Back to sign in
        </a>
    </form>
</x-layouts.auth>
