<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormReview extends Model
{
    protected $table = 'form_reviews';
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc')->orderBy('created_at', 'desc');
    }

    public function getFullnameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function getShortTextAttribute()
    {
        return strip_tags($this->text);
    }
}