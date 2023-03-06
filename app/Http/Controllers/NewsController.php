<?php

namespace App\Http\Controllers;

use App\Models\NewsGroup;
use App\Models\NewsItem;
use App\Resources\NewsCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $newsGroups = NewsGroup::active()->ordered()->get();
        $newsItems = NewsItem::active()->ordered()->with('parent')->get();

        return view('news.index', compact('newsItems', 'newsGroups'));
    }

    public function page($slug)
    {
        $newsItem = NewsItem::where('slug', $slug)->active()->ordered()->firstOrFail();

        return view('news.page', compact('newsItem'));
    }

    public function ajax(Request $request)
    {
        $group = (int)$request->group ?? 0;
        $date = $request->date ?? '';  // 'Y-m-d'
        $datePeriod = $request->date_period ?? '';  // [0 => 'Y-m-d', 1 => 'Y-m-d']

        if ($date) {
            $date = Carbon::parse($date)->format('Y-m-d H:i:s');
            $query = NewsItem::whereDate('date', $date);
        } elseif ($datePeriod) {
            $datePeriod = array_map(function ($item) {
                return Carbon::parse($item)->format('Y-m-d H:i:s');
            }, $datePeriod);

            $query = NewsItem::whereBetween('date', $datePeriod);
        }

        if ($group) {
            if ($date || $datePeriod)
                $query = $query->where('news_group_id', $group)->active()->ordered();
            else
                $query = NewsItem::where('news_group_id', $group)->active()->ordered();
        } else {
            if ($date || $datePeriod)
                $query = $query->active()->ordered();
            else
                $query = NewsItem::active()->ordered();
        }

        return new NewsCollection($query);
    }
}