<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFeedback extends Model
{
    protected $table = 'form_feedback';
    protected $guarded = ['id'];

    public function getTextAttribute($attr)
    {
        return strip_tags($attr);
    }
}