<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use FullTextSearch;

    protected $table = 'services';
    protected $guarded = ['id'];

    protected $searchable = [
        'name', 'text'
    ];

    public function prices()
    {
        return $this->hasMany(ServicePrice::class, 'service_id');
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