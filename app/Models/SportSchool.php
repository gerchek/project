<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SportSchool extends Model
{
    use FullTextSearch;

    protected $table = 'sport_schools';
    protected $guarded = ['id'];

    protected $searchable = [
        'name', 'main_text', 'banner_text', 'desc_text'
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
            while (SportSchool::where('slug', $item->slug)->where('id', '<>', $item->id)->exists()) {
                $item->slug = $firstSlug.'-'.$i;
                $i++;
            }
        });
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_sport_school', 'sport_school_id', 'employee_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getGalleryAttribute($attr)
    {
        return json_decode($attr);
    }

    public function getDescImagesAttribute($attr)
    {
        return json_decode($attr);
    }

    public function getMainTextAttribute($attr)
    {
        return strip_tags($attr);
    }

    public function getUrlAttribute()
    {
        return route('sport_school.page', $this->slug);
    }
}