<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socnet extends Model
{
    protected $table = 'socnets';
	protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        self::saved(function($item) {
            \Artisan::call('cache:clear');
        });
        self::deleted(function($item) {
            \Artisan::call('cache:clear');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

	public function setLinkAttribute($attr)
	{
		$this->attributes['link'] = trim($attr);
	}
}
