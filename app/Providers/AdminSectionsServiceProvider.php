<?php

namespace App\Providers;

use App\Admin\Elements\SvgImage;
use Illuminate\Routing\Router;
use SleepingOwl\Admin\Contracts\Navigation\NavigationInterface;
use SleepingOwl\Admin\Contracts\Template\MetaInterface;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{
    protected $widgets = [
        \App\Admin\Widgets\NavigationUserBlock::class,
    ];

    /**
     * @var array
     */
    protected $sections = [
        \App\Models\User::class => 'App\Admin\Sections\Users',
        \App\Models\Role::class => 'App\Admin\Sections\Roles',
        \App\Models\Menu::class => 'App\Admin\Sections\Menus',
        \App\Models\FooterMenu::class => 'App\Admin\Sections\FooterMenus',
        \App\Models\SimplePage::class => 'App\Admin\Sections\SimplePages',
        \App\Models\Slider::class => 'App\Admin\Sections\Slider',
        \App\Models\MainPage::class => 'App\Admin\Sections\MainPage',
        \App\Models\DocumentsGroup::class => 'App\Admin\Sections\DocumentsGroups',
        \App\Models\DocumentsItem::class => 'App\Admin\Sections\DocumentsItems',
        \App\Models\Contact::class => 'App\Admin\Sections\Contacts',
        \App\Models\Socnet::class => 'App\Admin\Sections\Socnets',
        \App\Models\PricesGroup::class => 'App\Admin\Sections\PricesGroups',
        \App\Models\Price::class => 'App\Admin\Sections\Prices',
        \App\Models\Service::class => 'App\Admin\Sections\Services',
        \App\Models\ServicePrice::class => 'App\Admin\Sections\ServicePrices',
        \App\Models\PartnerOffer::class => 'App\Admin\Sections\PartnerOffers',
        \App\Models\PartnerPhoto::class => 'App\Admin\Sections\PartnerPhotos',
        \App\Models\Vacancy::class => 'App\Admin\Sections\Vacancies',
        \App\Models\Schedule::class => 'App\Admin\Sections\Schedules',
        \App\Models\EmployeeGroup::class => 'App\Admin\Sections\EmployeeGroups',
        \App\Models\Employee::class => 'App\Admin\Sections\Employees',
        \App\Models\SportSchool::class => 'App\Admin\Sections\SportSchools',
        \App\Models\Diploma::class => 'App\Admin\Sections\Diplomas',
        \App\Models\FormReview::class => 'App\Admin\Sections\FormReviews',
        \App\Models\Gallery::class => 'App\Admin\Sections\Galleries',
        \App\Models\NewsGroup::class => 'App\Admin\Sections\NewsGroups',
        \App\Models\NewsItem::class => 'App\Admin\Sections\NewsItems',
        \App\Models\FormFeedback::class => 'App\Admin\Sections\FormFeedbacks',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        $this->registerPolicies( 'App\\Admin\\Policies\\' );

        $this->app->call( [ $this, 'registerRoutes' ] );
        $this->app->call( [ $this, 'registerNavigation' ] );

        parent::boot($admin);

        $this->app->call( [ $this, 'registerViews' ] );
        $this->app->call( [ $this, 'registerMediaPackages' ] );

        $this->app['sleeping_owl.form.element']->add('svgimage', SvgImage::class);
    }

    /**
     * @param NavigationInterface $navigation
     */
    public function registerNavigation( NavigationInterface $navigation ) {
        require base_path( 'app/Admin/navigation.php' );
    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews( WidgetsRegistryInterface $widgetsRegistry ) {
        foreach ( $this->widgets as $widget ) {
            $widgetsRegistry->registerWidget( $widget );
        }
    }

    /**
     * @param Router $router
     */
    public function registerRoutes( Router $router ) {
        $router->group( [
            'prefix'     => config( 'sleeping_owl.url_prefix' ),
            'middleware' => config( 'sleeping_owl.middleware' )
        ], function ( $router ) {
            require base_path( 'app/Admin/routes.php' );
        } );
    }

    /**
     * @param MetaInterface $meta
     */
    public function registerMediaPackages( MetaInterface $meta ) {
        $packages = $meta->assets()->packageManager();

        require base_path( 'app/Admin/assets.php' );
    }
}
