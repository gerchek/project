<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MenuComposer
{
	public function compose(View $view)
	{
        /* Кэшированное меню */
        $menu = Cache::rememberForever('menu', function () {
            $menu = Menu::active()
                ->orderBy('order', 'asc')
                ->with('childs', 'simplePage', 'childs.simplePage', 'childs.sportSchool', 'childs.newsItem')
                ->get();
            return $menu;
        });

        $view->with(compact('menu'));
	}
}
