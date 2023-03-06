<?php

namespace App\Http\Controllers;

use App\Models\Diploma;
use App\Models\FormReview;
use App\Resources\ThanksCollection;
use Illuminate\Http\Request;

class ThanksController extends Controller
{
    public function index()
    {
        $diplomas = Diploma::active()->ordered()->get();

        return view('thanks', compact('diplomas'));
    }

    public function ajax(Request $request)
    {
        $query = FormReview::active()->ordered();

        return new ThanksCollection($query);
    }
}