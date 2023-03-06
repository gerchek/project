<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    protected $table = 'menu_footer';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::saving(function($item) {
            if (!empty($item->news_item_id)) {
                $item->route = 'news.page';
            }
        });

        self::saved(function($item) {
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
        });
        self::deleted(function($item) {
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
        });
    }

    public function parent()
    {
        return $this->belongsTo(FooterMenu::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(FooterMenu::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function simplePage()
    {
        return $this->belongsTo(SimplePage::class);
    }

    public function newsItem()
    {
        return $this->belongsTo(NewsItem::class, 'news_item_id');
    }

    public function sportSchool()
    {
        return $this->belongsTo(SportSchool::class, 'sport_school_id');
    }

    public function getHrefAttribute()
    {
        $route = '';
        switch ($this->type)
        {
            case 'simple_page': $route = $this->simplePage ? $this->simplePage->url : '#'; break;
            case 'news_item_page': $route = $this->newsItem ? $this->newsItem->url : '#'; break;
            case 'sport_school_page': $route = $this->sportSchool ? $this->sportSchool->url : '#'; break;
            case 'custom_url': $route = $this->url; break;
            case 'no_url': $route = '#'; break;
            default: $route = ($this->route == 'index') ? '/' : route($this->route);
        }
        return $route;
    }
}
