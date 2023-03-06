<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use App\Models\Traits\Macros;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsItem extends Model
{
    use FullTextSearch;
    use Macros;

    protected $table = 'news_items';
    protected $guarded = ['id'];

    protected $searchable = [
        'name', 'text'
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
            while (NewsItem::where('slug', $item->slug)->where('id', '<>', $item->id)->exists()) {
                $item->slug = $firstSlug.'-'.$i;
                $i++;
            }

            if (!$item->date) {
                $item->date = $item->date = date('Y-m-d H:i:s');
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(NewsGroup::class, 'news_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function getUrlAttribute()
    {
        return route('news.page', $this->slug);
    }

    public function getTypeAttribute()
    {
        switch ($this->news_group_id) {
            case 1: $type = 'event'; break;
            case 2: $type = 'news'; break;
            case 3: $type = 'article'; break;
            default: $type = 'event';
        }

        return $type;
    }

    public function getProcessedTextAttribute()
    {
        return $this->macros('text');
    }
}