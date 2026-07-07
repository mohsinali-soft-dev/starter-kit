<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly SettingService $settings) {}

    public function edit(): View
    {
        $settings = $this->settings->values();

        return view('admin.settings.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $values = $this->settings->values();

        if ($request->hasFile('logo')) {
            if (! empty($values['logo'] ?? null)) {
                Storage::disk('public')->delete($values['logo']);
            }

            $values['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if (! empty($values['favicon'] ?? null)) {
                Storage::disk('public')->delete($values['favicon']);
            }

            $values['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $values['site_name'] = $request->validated('site_name');
        $values['currency'] = $request->validated('currency');
        $values['timezone'] = $request->validated('timezone');
        $values['contact_email'] = $request->validated('contact_email');

        $this->settings->fill($values);

        return back()->with('success', 'Settings updated successfully.');
    }
}
