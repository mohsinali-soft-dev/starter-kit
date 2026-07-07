@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Permissions', 'url' => route('admin.permissions.index')], ['label' => 'Edit']])

<x-layouts.admin title="Edit permission" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-12 col-lg-6"><x-form.input name="name" label="Permission name" :value="$permission->name" required /></div>
            <div class="col-12 col-lg-6"><x-form.input name="group_name" label="Group name" :value="$permission->group_name" /></div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">Update permission</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
