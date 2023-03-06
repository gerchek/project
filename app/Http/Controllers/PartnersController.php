<?php

namespace App\Http\Controllers;

use App\Models\PartnerPhoto;
use App\Models\PartnerOffer;

class PartnersController extends Controller
{
    public function index()
    {
        $photos = PartnerPhoto::active()->ordered()->get();
        $documents = PartnerOffer::active()->ordered()->get();

        return view('partners', compact('photos', 'documents'));
    }
}