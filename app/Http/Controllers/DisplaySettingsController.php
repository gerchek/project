<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class DisplaySettingsController extends Controller
{
    protected string $cookieName = 'special';
    public int $cookieLife = 14400;  // 10 дней

    public function setSpecialSettings(Request $request)
    {
        $classes = $request->classes;
        Cookie::queue($this->cookieName, $classes, $this->cookieLife);
        Cache::forget('special');

        return ['status' => 'ok'];
    }

    public function getSpecialClasses()
    {
        return request()->cookie('special');
    }
}