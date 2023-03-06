<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $guarded = ['id'];
	protected $table = 'contacts';

    protected $contactsNames = [
        'phone_1' => 'Телефон №1',
        'phone_1_desc' => 'Описание для телефона №1',
        'phone_2' => 'Телефон №2',
        'phone_2_desc' => 'Описание для телефона №2',
        'email' => 'E-mail',
        'address' => 'Адрес центра',
    ];

    protected static function boot()
    {
        parent::boot();

        self::saved(function($item) {
            \Artisan::call('cache:clear');
        });
    }

    public function getContactsName()
    {
        return $this->contactsNames[$this->name];
    }

    public function formatPhone($value)
    {
        return str_replace(['(', ')', '-',' '], "", $value);
    }

    public function getPhone1FullAttribute($attr)
    {
        if ($this->phone_1_desc) {
            return $this->phone_1.' ('.$this->phone_1_desc.')';
        } else {
            return $this->phone_1;
        }
    }

    public function getPhone2FullAttribute($attr)
    {
        if ($this->phone_2_desc) {
            return $this->phone_2.' ('.$this->phone_2_desc.')';
        } else {
            return $this->phone_2;
        }
    }
}
