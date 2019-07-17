<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingRequest;
use App\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * @var Setting[]|Collection
     */
    private $settingsCollection;


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only('updateSettings');
        $this->settingsCollection = Setting::all();
    }

    /**
     * Display edit general settings form.
     *
     * @return View
     */
    public function showGeneralSettingsForm(): View
    {
        return view('settings/settings', [
            'type' => 'general',
            'data' => $this->getSettingsFor('general'),
        ]);
    }

    /**
     * Display edit seo settings form.
     *
     * @return View
     */
    public function showSeoSettingsForm(): View
    {
        return view('settings/settings', [
            'type' => 'seo',
            'data' => $this->getSettingsFor('seo'),
        ]);
    }

    /**
     * Update settings.
     *
     * @param SaveSettingRequest $request
     *
     * @return JsonResponse
     */
    public function updateSettings(SaveSettingRequest $request): JsonResponse
    {
        foreach ($request->except(['_token', 'type']) as $name => $value) {
            Setting::updateOrCreate([
                'name' => $name,
            ], [
                'value' => $value
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.settings.settings-saved'),
        ]);
    }

    /**
     * Get settings array for specific type.
     *
     * @param string $settingsList
     *
     * @return Collection
     */
    private function getSettingsFor(string $settingsList): Collection
    {
        $allSettings = collect(Setting::SETTINGS_LIST[$settingsList])->keys();
        $existingSettings = Setting::whereIn('name', array_keys(Setting::SETTINGS_LIST[$settingsList]))->get();
        $missingSettings = $allSettings->diff($existingSettings->map(function ($setting) {
            return $setting->name;
        }));

        foreach ($missingSettings as $settingName) {
            $setting = new Setting();
            $setting->name = $settingName;

            $existingSettings->push($setting);
        }

        return $existingSettings;
    }
}
