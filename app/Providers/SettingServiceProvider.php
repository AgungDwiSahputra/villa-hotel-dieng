<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class SettingServiceProvider extends ServiceProvider
{
    protected $settingsCache = null; // Cache di level aplikasi (memori)

    public function boot()
    {
        $settings = Setting::pluck('value', 'key');
        view()->share('settings', $settings);
    }
}
