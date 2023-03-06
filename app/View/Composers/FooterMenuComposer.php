<?php

namespace App\View\Composers;

use App\Models\FooterMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FooterMenuComposer
{
	public function compose(View $view)
	{
        /* Кэшированное меню */
        $footerMenu = Cache::rememberForever('footer_menu', function () {
            $footerMenu = FooterMenu::active()
                ->orderBy('order', 'asc')
                ->with('childs', 'simplePage', 'childs.simplePage', 'childs.sportSchool', 'childs.newsItem')
                ->get();
            return $footerMenu;
        });

        $view->with(compact('footerMenu'));
	}
}
