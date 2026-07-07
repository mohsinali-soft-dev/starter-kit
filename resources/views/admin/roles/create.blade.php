@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Roles', 'url' => route('admin.roles.index')], ['label' => 'Create']])

<x-layouts.admin title="Create role" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <form method="POST" action="{{ route('admin.roles.store') }}" class="row g-3">
            @csrf
            <div class="col-12 col-lg-6"><x-form.input name="name" label="Role name" required /></div>

            <div class="col-12">
                <label class="form-label">Permissions</label>
                <div class="row g-3">
                    @foreach ($permissions as $group => $groupPermissions)
                        <div class="col-12 col-lg-6">
                            <div class="border rounded-4 p-3 bg-white h-100">
                                <div class="fw-semibold mb-3">{{ $group ?: 'General' }}</div>
                                <div class="row g-2">
                                    @foreach ($groupPermissions as $permission)
                                        <div class="col-12 col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">Save role</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
