<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;

class BreadcrumbsComposer
{
	public function compose(View $view)
	{
		$currentRoute = request()->route()->getName();
		if (strpos($currentRoute, '.')) {
			$currentRouteArray = explode('.', $currentRoute);
			$currentRoute = array_shift($currentRouteArray);
		}
		$currentMenuElement = Menu::active()->where('route', $currentRoute)->first();

		return $view->with('currentMenuElement', $currentMenuElement);
	}
}
