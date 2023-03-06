<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerPhoto extends Model
{
    protected $table = 'partner_photos';
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}