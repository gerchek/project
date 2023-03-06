<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(PricesGroup::class, 'prices_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public static function getGroupedPrices()
    {
        $prices = self::active()->ordered()->with('parent')->get();
        $groupedPrices = $prices->groupBy(['parent.name', function ($item, $key) {
            return $item;
        }]);

        return $groupedPrices;
    }

    public function getProcessedDurationAttribute()
    {
        return $this->duration.' минут';
    }
}