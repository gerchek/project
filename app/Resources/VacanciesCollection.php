<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VacanciesCollection extends ResourceCollection
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
            return [
                'post' => $item->name,
                'short_text' => strip_tags($item->short_text),
                'full_text' => $item->full_text,
            ];
        });
    }
}
