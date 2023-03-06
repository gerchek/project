<?php

namespace App\Http\Controllers;

use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::active()->ordered()->get();

        return view('schedule', compact('schedules'));
    }
}