<x-layouts.auth
    title="Password updated"
    eyebrow="Access restored"
    heading="You are ready to continue."
    copy="Your password has been updated. Sign in again to continue working in the dashboard."
>
    <div class="auth-state text-center">
        <div class="auth-state-icon auth-state-icon-success mx-auto mb-4">
            <i class="bi bi-check2"></i>
        </div>
        <div class="auth-heading auth-heading-center mb-4">
            <p class="auth-kicker">Password updated</p>
            <h2>Access restored</h2>
            <p>You can now sign in with your new password.</p>
        </div>
        <a class="btn btn-primary w-100 btn-lg" href="{{ route('login') }}">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
        </a>
    </div>
</x-layouts.auth>
