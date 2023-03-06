<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    /**
     * Пользователи
     */
    [
        'title' => 'Роли и права',
        'icon' => 'fa fa-user',
        'pages' => [
            (new Page(\App\Models\User::class))
                ->setIcon('fa fa-user')
                ->setPriority(10),
            (new Page(\App\Models\Role::class))
                ->setIcon('fa fa-people-carry')
                ->setPriority(20),
        ]
    ],

    /**
     * Меню (верхнее и нижнее)
     */
    [
        'title' => 'Меню',
        'icon' => 'fa fa-list-alt',
        'pages' => [
            (new Page(\App\Models\Menu::class))
                ->setIcon('fa fa-bars')
                ->setPriority(10),
            (new Page(\App\Models\FooterMenu::class))
                ->setIcon('fa fa-bars')
                ->setPriority(20),
        ]
    ],

    [
        'title' => 'Главная страница',
        'icon' => 'fa fa-list',
        'pages' => [
            (new Page(\App\Models\Slider::class))
                ->setIcon('fa fa-image'),
            (new Page(\App\Models\MainPage::class))
                ->setIcon('fa fa-home'),
        ]
    ],



    /**
     * Типовые страницы
     */
    (new Page(\App\Models\SimplePage::class))
        ->setIcon('fa fa-paperclip'),

    /**
     * Документы
     */
    [
        'title' => 'Документы',
        'icon' => 'fa fa-file',
        'pages' => [
            (new Page(\App\Models\DocumentsGroup::class))
                ->setIcon('fa fa-bars'),
            (new Page(\App\Models\DocumentsItem::class))
                ->setIcon('fa fa-file-text')
                ->addBadge(function() {
                    return \App\Models\DocumentsItem::count();
                })
        ]
    ],

    /**
     * Персонал
     */
    [
        'title' => 'Персонал',
        'icon' => 'fa fa-users',
        'pages' => [
            (new Page(\App\Models\EmployeeGroup::class))
                ->setIcon('fa fa-bars')
                ->setPriority(10),
            (new Page(\App\Models\Employee::class))
                ->setIcon('fa fa-user-plus')
                ->setPriority(20)
        ]
    ],

    /**
     * Вакансии
     */
    (new Page(\App\Models\Vacancy::class))
        ->setIcon('fa fa-people-carry'),

    /**
     * Спортивная школа
     */
    (new Page(\App\Models\SportSchool::class))
        ->setIcon('fa fa-home'),

    /**
     * Партнерам
     */
    [
        'title' => 'Партнерам',
        'icon' => 'fa fa-hands-helping',
        'pages' => [
            (new Page(\App\Models\PartnerPhoto::class))
                ->setIcon('fa fa-image')
                ->setPriority(10),
            (new Page(\App\Models\PartnerOffer::class))
                ->setIcon('fa fa-file')
                ->setPriority(20)
        ]
    ],

    /**
     * Услуги
     */
    (new Page(\App\Models\Service::class))
        ->setIcon('fa fa-list'),

    /**
     * Прайсы
     */
    [
        'title' => 'Прайсы',
        'icon' => 'fa fa-rub',
        'pages' => [
            (new Page(\App\Models\PricesGroup::class))
                ->setIcon('fa fa-bars')
                ->setPriority(10),
            (new Page(\App\Models\Price::class))
                ->setIcon('fa fa-rub')
                ->setPriority(20)
        ]
    ],

    /**
     * Расписание
     */
    (new Page(\App\Models\Schedule::class))
        ->setIcon('fa fa-calendar'),

    /**
     * Галерея
     */
    (new Page(\App\Models\Gallery::class))
        ->setIcon('fa fa-images'),

    /**
     * Новости
     */
    [
        'title' => 'Новости',
        'icon' => 'fa fa-bookmark',
        'pages' => [
            (new Page(\App\Models\NewsGroup::class))
                ->setIcon('fa fa-bars')
                ->setPriority(10),
            (new Page(\App\Models\NewsItem::class))
                ->setIcon('fa fa-bookmark')
                ->setPriority(20)
        ]
    ],

    /**
     * Благодарности
     */
    [
        'title' => 'Благодарности',
        'icon' => 'fa fa-share',
        'pages' => [
            (new Page(\App\Models\Diploma::class))
                ->setIcon('fa fa-image')
                ->setPriority(10),
            (new Page(\App\Models\FormReview::class))
                ->setIcon('fa fa-paper-plane')
                ->setPriority(20)
                ->addBadge(function() {
                    return \App\Models\FormReview::count();
                }),
        ]
    ],

    /**
     * Обратная связь
     */
    (new Page(\App\Models\FormFeedback::class))
        ->setIcon('fa fa-paper-plane')
        ->addBadge(function() {
            return \App\Models\FormFeedback::count();
        }),

    /**
     * Контакты
     */
    [
        'title' => 'Контакты',
        'icon' => 'fa fa-home',
        'pages' => [
            (new Page(\App\Models\Contact::class))
                ->setIcon('fa fa-home')
                ->setPriority(10),
            (new Page(\App\Models\Socnet::class))
                ->setIcon('fa fa-share-alt')
                ->setPriority(20)
        ]
    ],

    /**
     * Системные настройки
     */
//    [
//        'title' => 'Системные настройки',
//        'icon'  => 'fa fa-server',
//        'url'   => url('admin/settings'),
//    ],

    /**
     * Логи сервера
     */
    [
        'title' => 'Логи сервера',
        'icon' => 'fa fa-table',
        'url' => route('admin.logs'),
    ],

    /**
     * Очистка кэша
     */
    [
        'title' => 'Очистка кэша',
        'icon' => 'fa fa-recycle',
        'url' => route('admin.cache.list'),
    ],
];
