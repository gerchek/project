<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getTypeAttribute()
    {
        $type = '';
        if (\File::exists($this->file)) {
            $mimeType = \File::mimeType($this->file);
            if ($mimeType == 'application/pdf') {
                $type = 'pdf';
            } elseif ($mimeType == 'image/jpeg' || $mimeType == 'image/pjpeg' || $mimeType == 'image/png') {
                $type = 'img';
            }
        }

        return $type;
    }
}