<?php

namespace App\Http\Controllers;

use App\Models\MainPage;
use App\Models\NewsItem;
use App\Models\Slider;
use App\Models\SportSchool;

class IndexController extends Controller
{
    public function index()
    {
        $slider = Slider::active()->orderBy('order', 'asc')->get();
        $sportSchools = SportSchool::where('main', 1)->active()->ordered()->get();
        $newsItems = NewsItem::active()->ordered()->with('parent')->limit(5)->get();
        $mainPageSettings = MainPage::first();

        return view('index', compact('slider', 'sportSchools', 'newsItems', 'mainPageSettings'));
    }
}
