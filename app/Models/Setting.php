<?php

namespace App\Models;

use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class Setting extends Valuestore
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSettings()
    {
        $settings = $this->all();

        return \AdminSection::view(view('admin.settings.form', compact('settings')));
    }

    public function updateSettings(Request $request)
    {
        $settings = collect($request->all())->except('_token');
        foreach ($settings as $settingName => $settingValue) {
            $this->put($settingName, $settingValue);
        }

        return $this->getSettings();
    }
}
