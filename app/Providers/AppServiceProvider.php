<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use KodiCMS\Assets\Facades\Meta;
use KodiCMS\Assets\Facades\PackageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Setting::class, function () {
            return Setting::make(storage_path('app/settings.json'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        PackageManager::add('tinymce5')
            ->js('tinymce.js', env('TINY_MCE_JS_PATH'))
            ->js('tinymce_langs.js', asset('js/tinymce5/langs/ru.js'))
            ->js('custom_tinymce.js', asset('js/tinymce5/custom_tinymce.js'));

        Meta::loadPackage(['tinymce5']);

        /*
         * Paginate the given collection
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         *
         * @return \Illuminate\Pagination\LengthAwarePaginator
         */
        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function (int $perPage = 15, string $pageName = 'page', int $page = null, int $total = null, array $options = []): LengthAwarePaginator {
                $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
                $results = $this->forPage($page, $perPage);
                $total = $total ?: $this->count();
                $options += [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ];
                return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
            });
        }
    }
}
