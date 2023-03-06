<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vacancy extends Model
{
    use FullTextSearch;

    protected $table = 'vacancies';
    protected $guarded = ['id'];

    protected $searchable = [
        'name', 'full_text'
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
            while (Vacancy::where('slug', $item->slug)->where('id', '<>', $item->id)->exists()) {
                $item->slug = $firstSlug.'-'.$i;
                $i++;
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getUrlAttribute()
    {
        return route('vacancies.page', $this->slug);
    }
}