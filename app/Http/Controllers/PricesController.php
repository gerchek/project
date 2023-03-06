<?php

namespace App\Http\Controllers;

use App\Models\Price;

class PricesController extends Controller
{
    public function index()
    {
        $groupedPrices = Price::getGroupedPrices();

        return view('prices', compact('groupedPrices'));
    }
}