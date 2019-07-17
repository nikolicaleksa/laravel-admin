<?php

namespace App\Providers;

use Exception;
use App\Setting;
use Illuminate\Support\ServiceProvider;

class SettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $settings = [];

            foreach (Setting::all() as $setting) {
                $settings[$setting->name] = $setting->value;
            }

            view()->share('settings', $settings);
        } catch (Exception $ex) {

        }
    }
}
