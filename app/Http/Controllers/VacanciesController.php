<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Resources\VacanciesCollection;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    public function index()
    {
        return view('vacancies.index');
    }

//    public function page($slug)
//    {
//        $vacancy = Vacancy::active()->where('slug', $slug)->firstOrFail();
//
//        return view('vacancies.page', compact('vacancy'));
//    }

    public function ajax(Request $request)
    {
        $query = Vacancy::active()->ordered();

        return new VacanciesCollection($query);
    }
}