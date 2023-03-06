<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainPage extends Model
{
	protected $guarded = ['id'];
	protected $table = 'main_page';

    protected static function boot()
    {
        parent::boot();

        self::saved(function($item) {
            \Artisan::call('cache:clear');
        });
    }
}
