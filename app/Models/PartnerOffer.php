<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerOffer extends Model
{
    protected $table = 'partner_offers';
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

    public function getTypeAttribute()
    {
        $type = '';
        if (\File::exists($this->file)) {
            $mimeType = \File::mimeType($this->file);
            if ($mimeType == 'application/pdf') {
                $type = 'pdf';
            } elseif ($mimeType == 'application/msword' ||
                $mimeType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $type = 'doc';
            }
        }

        return $type;
    }

    public function getDownloadAttribute()
    {
        if (!empty($this->type) && $this->type == 'doc') {
            return 'download';
        } else {
            return '';
        }
    }
}