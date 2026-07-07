@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Profile']])

<x-layouts.admin title="Profile" :breadcrumbs="$breadcrumbs">
    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="panel-card h-100">
                <h2 class="h5 mb-3">Profile details</h2>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12"><x-form.input name="name" label="Full name" :value="$user->name" required /></div>
                    <div class="col-12"><x-form.input name="email" label="Email address" type="email" :value="$user->email" required /></div>
                    <div class="col-12">
                        <label class="form-label">Avatar</label>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img class="avatar-circle" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            <div class="text-secondary small">Upload a square image for the best result.</div>
                        </div>
                        <input class="form-control" type="file" name="avatar" accept="image/*">
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Save profile</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="panel-card mb-4">
                <h2 class="h5 mb-3">Change password</h2>
                <form method="POST" action="{{ route('profile.password') }}" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12"><x-form.input name="current_password" label="Current password" type="password" required /></div>
                    <div class="col-12"><x-form.input name="password" label="New password" type="password" required /></div>
                    <div class="col-12"><x-form.input name="password_confirmation" label="Confirm new password" type="password" required /></div>
                    <div class="col-12 d-flex justify-content-end"><button class="btn btn-primary" type="submit">Update password</button></div>
                </form>
            </div>

            <div class="panel-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Session management</h2>
                    <form method="POST" action="{{ route('profile.sessions.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-secondary btn-sm" type="submit">Logout other sessions</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>User agent</th>
                                <th class="text-end">Last activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sessions as $session)
                                <tr>
                                    <td>{{ $session->ip_address ?? 'Unknown' }}</td>
                                    <td class="text-secondary small">{{ str($session->user_agent ?? 'Unknown')->limit(55) }}</td>
                                    <td class="text-end text-secondary">{{ \Illuminate\Support\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-secondary py-4">No sessions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-card border-danger border-opacity-25">
                <h2 class="h5 text-danger mb-3">Delete account</h2>
                <form method="POST" action="{{ route('profile.destroy') }}" class="row g-3">
                    @csrf
                    @method('DELETE')
                    <div class="col-12">
                        <x-form.input name="password" label="Confirm password" type="password" required />
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-danger" type="submit">Delete my account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
