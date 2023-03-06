<?php

namespace App\Http\Controllers;

use App\Models\SimplePage;

class SimplePageController extends Controller
{
    public function page($slug)
    {
        $page = SimplePage::active()->where('slug', $slug)->firstOrFail();

        return view('simple.page', compact('page'));
    }
}
