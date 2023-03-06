<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricesGroup extends Model
{
    protected $table = 'prices_groups';
    protected $guarded = ['id'];

    public function childs()
    {
        return $this->hasMany(Price::class, 'prices_group_id');
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