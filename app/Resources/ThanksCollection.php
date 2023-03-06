<?php

namespace App\Resources;

use App\Models\FormReview;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class ThanksCollection extends ResourceCollection
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
            $formReview = FormReview::where('id', $item->id)->firstOrFail();

            return [
                'name' => $formReview->fullname,
                'short_text' => Str::words($formReview->shortText, 15, '...'),
                'full_text' => $item->text,
            ];
        });
    }
}
