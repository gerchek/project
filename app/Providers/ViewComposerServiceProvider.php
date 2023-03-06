<?php

namespace App\Providers;

use App\View\Composers\BreadcrumbsComposer;
use App\View\Composers\ContactsComposer;
use App\View\Composers\DisplaySettingsComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\FooterMenuComposer;
use App\View\Composers\SocnetsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.top_menu', MenuComposer::class);
        View::composer('components.bottom_menu', FooterMenuComposer::class);
        View::composer(['header', 'footer', 'contacts'], ContactsComposer::class);
        View::composer(['footer', 'contacts'], SocnetsComposer::class);
        View::composer('components.breadcrumbs', BreadcrumbsComposer::class);
        View::composer('layouts.main', DisplaySettingsComposer::class);
    }
}