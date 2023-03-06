<?php

namespace App\Resources;

use App\Models\NewsItem;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class NewsCollection extends ResourceCollection
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
            $model = NewsItem::where('id', $item->id)->firstOrFail();
            $url = $model->url;
            $type = $model->type;
            $tag = $model->parent->name;

            return [
                'title' => Str::words($item->name, 15, '...'),
                'link' => $url,
                'type' => $type,
                'tag' => $tag,
                'tagLink' => $url,
                'img' => $item->image,
                'date' => Carbon::parse($item->date)->format('d.m.Y'),
            ];
        })->paginate(15);
    }
}
