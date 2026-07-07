@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Permissions', 'url' => route('admin.permissions.index')], ['label' => 'Create']])

<x-layouts.admin title="Create permission" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <form method="POST" action="{{ route('admin.permissions.store') }}" class="row g-3">
            @csrf

            <div class="col-12 col-lg-6"><x-form.input name="name" label="Permission name" required /></div>
            <div class="col-12 col-lg-6"><x-form.input name="group_name" label="Group name" /></div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">Save permission</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
