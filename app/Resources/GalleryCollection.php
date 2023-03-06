<?php

namespace App\Resources;

use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class GalleryCollection extends ResourceCollection
{
    // public static $wrap = 'results';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->get()->map(function ($item) use ($request) {
            $model = Gallery::where('id', $item->id)->firstOrFail();
            $url = $model->url;

            return [
                'title' => Str::words($item->name, 15, '...'),
                'link' => $url,
                'img' => $item->cover,
                'date' => Carbon::parse($item->date)->translatedFormat('j F Y'),
            ];
        })->paginate(15);
    }
}
