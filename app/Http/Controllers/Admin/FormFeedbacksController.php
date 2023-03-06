<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormFeedback;

class FormFeedbacksController extends Controller
{
    /**
     *
     */
    function allDelete()
    {
        FormFeedback::query()->delete();
        return back();
    }

    /**
     *
     */
    function selectedDelete($ids)
    {
        $ids = explode(',', $ids);
        FormFeedback::destroy($ids);
        return back();
    }
}
