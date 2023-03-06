<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\NewsItem;
use App\Models\Service;
use App\Models\SimplePage;
use App\Models\SportSchool;
use App\Models\Vacancy;
use Illuminate\Support\Str;
use Whoops\Exception\ErrorException;

class SearchController extends Controller
{
    public function getSearchResult()
    {
        $searchResults = collect();

        if (!empty(request()->search_query)) {
            $searchData = $this->search(request()->search_query);

            foreach ($searchData as $searchResult) {
                switch (true) {
                    case $searchResult instanceof Gallery:
                        $searchResults->push([
                            'name' => $searchResult->name,
                            'url' => route('gallery.page', $searchResult->slug),
                            'text' => '',
                        ]);
                        break;
                    case $searchResult instanceof NewsItem:
                        $searchResults->push([
                            'name' => $searchResult->name,
                            'url' => route('news.page', $searchResult->slug),
                            'text' => Str::words(strip_tags($searchResult->text), 30, '...'),
                        ]);
                        break;
                    case $searchResult instanceof Service:
                        $searchResults->push([
                            'name' => $searchResult->name,
                            'url' => route('services'),
                            'text' => Str::words(strip_tags($searchResult->text), 30, '...'),
                        ]);
                        break;
                    case $searchResult instanceof SimplePage:
                        $searchResults->push([
                            'name' => $searchResult->title,
                            'url' => route('simple.page', $searchResult->slug),
                            'text' => Str::words(strip_tags($searchResult->text), 30, '...'),
                        ]);
                        break;
                    case $searchResult instanceof SportSchool:
                        $searchResults->push([
                            'name' => $searchResult->name,
                            'url' => route('sport_school.page', $searchResult->slug),
                            'text' => Str::words(strip_tags($searchResult->desc_text), 30, '...'),
                        ]);
                        break;
                    case $searchResult instanceof Vacancy:
                        $searchResults->push([
                            'name' => $searchResult->name,
                            'url' => route('vacancies.page', $searchResult->slug),
                            'text' => Str::words(strip_tags($searchResult->full_text), 30, '...'),
                        ]);
                        break;
                }
            }
        } else {
            $searchResults->push(null);
        }

        return response()->json([
            'searchResults' => $searchResults->paginate(15),
            // 'quantity' => $searchResults->count()
        ]);
    }

    public function search($searchQuery)
    {
        $searchResults = collect();

        try {
            $galleriesSearchResults = Gallery::search($searchQuery)->get();
            if ($galleriesSearchResults->count() > 0)
                $searchResults->push($galleriesSearchResults);

            $newsItemsSearchResults = NewsItem::search($searchQuery)->get();
            if ($newsItemsSearchResults->count() > 0)
                $searchResults->push($newsItemsSearchResults);

            $servicesSearchResults = Service::search($searchQuery)->get();
            if ($servicesSearchResults->count() > 0)
                $searchResults->push($servicesSearchResults);

            $simplePagesSearchResults = SimplePage::search($searchQuery)->get();
            if ($simplePagesSearchResults->count() > 0)
                $searchResults->push($simplePagesSearchResults);

            $sportSchoolPageSearchResults = SportSchool::search($searchQuery)->get();
            if ($sportSchoolPageSearchResults->count() > 0)
                $searchResults->push($sportSchoolPageSearchResults);

            $vacanciesPageSearchResults = Vacancy::search($searchQuery)->get();
            if ($vacanciesPageSearchResults->count() > 0)
                $searchResults->push($vacanciesPageSearchResults);

            $searchResults = $searchResults->collapse();
            $searchResults = $searchResults->sortByDesc('relevance_score');

            return $searchResults;
        } catch (ErrorException $e) {
            return $e->getMessage();
        }
    }
}