<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(EmployeeGroup::class, 'employee_group_id');
    }

    public function schools()
    {
        return $this->belongsToMany(SportSchool::class, 'employee_sport_school', 'employee_id', 'sport_school_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getShortTextAttribute($attr)
    {
        return strip_tags($attr);
    }
}