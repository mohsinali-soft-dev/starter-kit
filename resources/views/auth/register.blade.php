<x-layouts.auth
    title="Create account"
    eyebrow="New workspace user"
    heading="Start with a verified profile."
    copy="Create a customer account, verify the email address, and continue into the workspace once verification is complete."
>
    <form action="{{ route('register.store') }}" method="POST" novalidate>
        @csrf

        <div class="auth-heading mb-4">
            <p class="auth-kicker">Create account</p>
            <h2>Register your profile</h2>
            <p>We will send a verification email after signup.</p>
        </div>

        <div class="mb-3">
            <label class="form-label" for="name">Full name</label>
            <div class="input-shell">
                <i class="bi bi-person" aria-hidden="true"></i>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" required autofocus>
            </div>
            @error('name')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <div class="input-shell">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
            </div>
            @error('email')
                <div class="invalid-copy">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <div class="input-shell">
                <i class="bi bi-lock" aria-hidden="true"></i>
                <input class="form-control" type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" required>
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
            <i class="bi bi-person-plus me-2"></i>Create account
        </button>

        <p class="text-center small mb-0 text-secondary">
            Already have an account?
            <a class="fw-semibold" href="{{ route('login') }}">Sign in</a>
        </p>
    </form>
</x-layouts.auth>
