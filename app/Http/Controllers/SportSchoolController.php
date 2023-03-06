<?php

namespace App\Http\Controllers;

use App\Models\SportSchool;

class SportSchoolController extends Controller
{
    public function page($slug)
    {
        $sportSchool = SportSchool::where('slug', $slug)->active()->ordered()->firstOrFail();

        return view('sport_schools.page', compact('sportSchool'));
    }
}