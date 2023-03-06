<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Resources\GalleryCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::active()->ordered()->get();

        return view('gallery.index', compact('galleries'));
    }

    public function page($slug)
    {
        $gallery = Gallery::where('slug', $slug)->active()->ordered()->firstOrFail();

        return view('gallery.page', compact('gallery'));
    }

    public function ajax(Request $request)
    {
        $date = $request->date ?? '';  // 'Y-m-d'
        $datePeriod = $request->date_period ?? '';  // [0 => 'Y-m-d', 1 => 'Y-m-d']

        if ($date) {
            $date = Carbon::parse($date)->format('Y-m-d H:i:s');
            $query = Gallery::whereDate('date', $date);
        } elseif ($datePeriod) {
            $datePeriod = array_map(function ($item) {
                return Carbon::parse($item)->format('Y-m-d H:i:s');
            }, $datePeriod);

            $query = Gallery::whereBetween('date', $datePeriod);
        }

        if ($date || $datePeriod)
            $query = $query->active()->ordered();
        else
            $query = Gallery::active()->ordered();

        return new GalleryCollection($query);
    }
}