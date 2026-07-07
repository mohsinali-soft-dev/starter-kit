<?php

use App\Services\SettingService;

if (! function_exists('setting')) {
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $service = app(SettingService::class);

        if ($key === null) {
            return $service->values();
        }

        return $service->value($key, $default);
    }
}

if (! function_exists('public_settings')) {
    function public_settings(): array
    {
        return app(SettingService::class)->publicValues();
    }
}
