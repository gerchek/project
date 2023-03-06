<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeGroup extends Model
{
    protected $table = 'employee_groups';
    protected $guarded = ['id'];

    public function childs()
    {
        return $this->hasMany(Employee::class, 'employee_group_id');
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