<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsGroup extends Model
{
    protected $table = 'news_groups';
    protected $guarded = ['id'];

    public function childs()
    {
        return $this->hasMany(NewsItem::class, 'news_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}