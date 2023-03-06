<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use FullTextSearch;

    protected $table = 'galleries';
    protected $guarded = ['id'];

    protected $searchable = [
        'name'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        self::saving(function($item) {
            if (!$item->slug) {
                $item->slug = Str::slug($item->name);
            }

            $firstSlug = $item->slug;
            $i = 2;
            while (Gallery::where('slug', $item->slug)->where('id', '<>', $item->id)->exists()) {
                $item->slug = $firstSlug.'-'.$i;
                $i++;
            }

            if (!$item->date) {
                $item->date = $item->date = date('Y-m-d H:i:s');
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    public function getImagesAttribute($attr)
    {
        return json_decode($attr);
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('j F Y');
    }

    public function getUrlAttribute()
    {
        return route('gallery.page', $this->slug);
    }
}