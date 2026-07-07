@php($breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Settings']])

<x-layouts.admin title="Settings" :breadcrumbs="$breadcrumbs">
    <div class="panel-card">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-12 col-lg-6"><x-form.input name="site_name" label="Site name" :value="$settings['site_name'] ?? config('app.name')" required /></div>
            <div class="col-12 col-lg-3"><x-form.input name="currency" label="Currency" :value="$settings['currency'] ?? 'USD'" required /></div>
            <div class="col-12 col-lg-3"><x-form.input name="timezone" label="Timezone" :value="$settings['timezone'] ?? config('app.timezone')" required /></div>
            <div class="col-12 col-lg-6"><x-form.input name="contact_email" label="Contact email" type="email" :value="$settings['contact_email'] ?? config('mail.from.address')" required /></div>

            <div class="col-12 col-lg-3">
                <label class="form-label">Logo</label>
                @if (! empty($settings['logo'] ?? null))
                    <div class="mb-2">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['logo']) }}" alt="Logo" style="max-height: 56px;">
                    </div>
                @endif
                <input class="form-control" type="file" name="logo" accept="image/*">
            </div>

            <div class="col-12 col-lg-3">
                <label class="form-label">Favicon</label>
                @if (! empty($settings['favicon'] ?? null))
                    <div class="mb-2">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['favicon']) }}" alt="Favicon" style="max-height: 32px;">
                    </div>
                @endif
                <input class="form-control" type="file" name="favicon" accept="image/*">
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <button class="btn btn-primary" type="submit">Save settings</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
