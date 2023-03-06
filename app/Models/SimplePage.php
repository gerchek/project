<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use App\Models\Traits\Macros;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SimplePage extends Model
{
    use FullTextSearch;
    use Macros;

    protected $table = 'simple_pages';
    protected $guarded = ['id'];

    protected $searchable = [
        'title', 'text'
    ];

    protected static function boot()
    {
        parent::boot();

        self::saving(function($item) {
            if (!$item->slug) {
                $item->slug = Str::slug($item->title);
            }

            $firstSlug = $item->slug;
            $i = 2;
            while (self::where('slug', $item->slug)->where('id', '<>', $item->id)->exists()) {
                $item->slug = $firstSlug.'-'.$i;
                $i++;
            }
        });
    }

    public function relatedModels($model)
    {
        return $this->hasMany($model, 'simple_page_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getUrlAttribute()
    {
        return route('simple.page', $this->slug, false);
    }

    public function getProcessedTextAttribute()
    {
        return $this->macros('text');
    }
}
