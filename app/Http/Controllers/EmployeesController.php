<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Resources\EmployeesCollection;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function trainers()
    {
        $employeesGroups = EmployeeGroup::where('type', 'trainers')->active()->ordered()->get();

        return view('employees.trainers', compact('employeesGroups'));
    }

    public function management()
    {
        $employeesGroups = EmployeeGroup::where('type', 'management')->active()->ordered()->get();

        return view('employees.management', compact('employeesGroups'));
    }

    public function ajax(Request $request)
    {
        $group = (int)$request->group ?? 0;
        $type = $request->type ?? '';

        if ($group)
            $query = Employee::where('employee_group_id', $group)->whereHas('parent', function($query) use ($type) {
                $query->where('type', $type);
            })->active()->ordered();
        else
            $query = Employee::whereHas('parent', function($query) use ($type) {
                $query->where('type', $type);
            })->active()->ordered();

        return new EmployeesCollection($query);
    }
}