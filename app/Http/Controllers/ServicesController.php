<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->with('prices')->get();

        return view('services', compact('services'));
    }
}