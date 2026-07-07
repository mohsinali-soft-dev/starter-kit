<x-layouts.auth
    title="Check your email"
    eyebrow="Email sent"
    heading="Your reset link is on the way."
    copy="For security, password reset links expire automatically. Request a fresh one if the link is no longer valid."
>
    <div class="auth-state text-center">
        <div class="auth-state-icon mx-auto mb-4">
            <i class="bi bi-envelope-check"></i>
        </div>
        <div class="auth-heading auth-heading-center mb-4">
            <p class="auth-kicker">Check your inbox</p>
            <h2>We sent the reset link</h2>
            <p>Look for an email sent to {{ $email ?? request('email', 'your account email') }}.</p>
        </div>
        <a class="btn btn-primary w-100 btn-lg mb-3" href="https://mail.google.com/mail/u/0/#inbox" target="_blank" rel="noreferrer">
            <i class="bi bi-envelope-open me-2"></i>Open email
        </a>
        <a class="auth-back-link justify-content-center" href="{{ route('password.request') }}">Use another email</a>
    </div>
</x-layouts.auth>
