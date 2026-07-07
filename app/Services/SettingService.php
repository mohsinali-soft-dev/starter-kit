<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public const CACHE_KEY = 'app.settings';

    public function all(): Collection
    {
        $settings = Cache::get(self::CACHE_KEY);

        if ($settings instanceof Collection) {
            return $settings;
        }

        $settings = Setting::query()->orderBy('group', 'asc')->orderBy('label', 'asc')->get();

        Cache::forever(self::CACHE_KEY, $settings);

        return $settings;
    }

    public function value(string $key, mixed $default = null): mixed
    {
        return $this->all()->firstWhere('key', $key)?->value ?? $default;
    }

    public function values(): array
    {
        return $this->all()->pluck('value', 'key')->all();
    }

    public function publicValues(): array
    {
        return $this->all()->where('is_public', true)->pluck('value', 'key')->all();
    }

    public function fill(array $payload): void
    {
        foreach ($payload as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->forget();
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
