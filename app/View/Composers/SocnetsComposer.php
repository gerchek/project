<?php

namespace App\View\Composers;

use App\Models\Socnet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class SocnetsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $socnets = Cache::rememberForever('socnets', function () {
            return Socnet::active()->orderBy('order', 'asc')->get();
        });

        $view->with(compact('socnets'));
    }
}