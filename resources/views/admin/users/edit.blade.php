@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Users', 'url' => route('admin.users.index')], ['label' => 'Edit']])

<x-layouts.admin title="Edit user" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-12 col-lg-6"><x-form.input name="name" label="Full name" :value="$user->name" required /></div>
            <div class="col-12 col-lg-6"><x-form.input name="email" label="Email address" type="email" :value="$user->email" required /></div>
            <div class="col-12 col-lg-6"><x-form.input name="password" label="Password" type="password" /></div>
            <div class="col-12 col-lg-6"><x-form.input name="password_confirmation" label="Confirm password" type="password" /></div>
            <div class="col-12 col-lg-6"><x-form.input name="avatar" label="Avatar" type="file" /></div>
            <div class="col-12 col-lg-6"><x-form.checkbox name="is_active" label="Active account" :checked="$user->is_active" /></div>

            <div class="col-12">
                <label class="form-label">Roles</label>
                <div class="row g-2">
                    @php($currentRoles = $user->roles->pluck('id')->map(fn ($id) => (string) $id)->all())
                    @foreach ($roles as $role)
                        <div class="col-12 col-md-4">
                            <div class="form-check border rounded-3 p-3 bg-white">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}" @checked(in_array((string) $role->id, $currentRoles, true))>
                                <label class="form-check-label ms-2" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">Update user</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
