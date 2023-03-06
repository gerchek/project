<?php

namespace App\View\Composers;

use App\Http\Controllers\DisplaySettingsController;
use Illuminate\Contracts\View\View;

class DisplaySettingsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $specialClasses = (new DisplaySettingsController)->getSpecialClasses();

        $view->with(compact('specialClasses'));
    }
}