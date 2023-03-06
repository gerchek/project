<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Menus
 *
 * @property \App\Models\Menu $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Menus extends Section implements Initializable
{
	protected $types = [
		'default' => 'Ссылка на раздел сайта',
		'simple_page' => 'Ссылка на типовую страницу',
		'news_item_page' => 'Ссылка на страницу события',
		'sport_school_page' => 'Ссылка на страницу спортивной школы',
		'custom_url' => 'Внешняя ссылка',
		'no_url' => 'Без ссылки',
	];

	protected $routes = [
        'index' => 'Главная страница',
        // 'sport_school' => 'Спортивная школа',
        'services' => 'Услуги',
        'prices' => 'Стоимость услуг',
        'schedule' => 'Расписание',
        'news' => 'События',
        'contacts' => 'Контакты',
        'team' => 'Тренерский состав',
        'management' => 'Руководство',
        'documents' => 'Документы',
        'partners' => 'Партнерам',
        'gallery' => 'Галерея',
        'thanks' => 'Благодарности',
        'vacancies' => 'Вакансии',
	];

	/**
	 * @var bool
	 */
	protected $checkAccess = false;

	/**
	 * @var string
	 */
	protected $title = 'Меню';

	/**
	 * @var string
	 */
	protected $alias;

	/**
	 * Initialize class.
	 */
	public function initialize()
	{
		//
	}

	/**
	 * @param array $payload
	 *
	 * @return DisplayInterface
	 */
	public function onDisplay($payload = [])
	{
		$display = AdminDisplay::tree();
        $display->setParentField('parent_id');
        $display->setOrderField('order');
        $display->setRootParentId(0);
        $display->setValue('title');

		return $display;
	}

	/**
	 * @param int|null $id
	 * @param array $payload
	 *
	 * @return FormInterface
	 */
	public function onEdit($id = null, $payload = [])
	{
        $maxOrderVal = $this->model->max('id');

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('title', 'Заголовок')->required(),
                    AdminFormElement::select('parent_id', 'Родительский пункт меню')
                        ->setModelForOptions(\App\Models\Menu::class)
                        ->setLoadOptionsQueryPreparer(function ($element, $query) {
                            return $query->whereNull('parent_id')->orWhere('parent_id', 0);
                        })
                        // ->exclude([$id])
                        ->setSortable(false)
                        ->setDisplay('title'),
                    AdminFormElement::select('type', 'Тип', $this->types)->required()
                        ->setDefaultValue('default')
                        ->setHtmlAttribute('class', 'js-menu-type-select'),
                    AdminFormElement::text('url', 'URL')
                        ->setHtmlAttribute('class', 'js-menu-url'),
                    AdminFormElement::select('route', 'Раздел сайта', $this->routes)
                        ->setHtmlAttribute('class', 'js-menu-route-select'),
                    AdminFormElement::selectajax('simple_page_id', 'Типовая страница')
                        ->setModelForOptions(\App\Models\SimplePage::class, 'title')
                        ->setHtmlAttribute('class', 'js-menu-simple-page-select'),
                    AdminFormElement::selectajax('news_item_id', 'Событие')
                        ->setModelForOptions(\App\Models\NewsItem::class, 'name')
                        ->setHtmlAttribute('class', 'js-menu-news-item-select'),
                    AdminFormElement::selectajax('sport_school_id', 'Страница спортивной школы')
                        ->setModelForOptions(\App\Models\SportSchool::class, 'name')
                        ->setHtmlAttribute('class', 'js-menu-sport-school-select'),
                    AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                    AdminFormElement::text('order', 'Сортировка')->setDefaultValue(($maxOrderVal + 1)),
                ], 'col')
        ]);

		return $form;
	}

	/**
	 * @return FormInterface
	 */
	public function onCreate($payload = [])
	{
		return $this->onEdit(null, $payload);
	}

	/**
	 * @return bool
	 */
	public function isDeletable(Model $model)
	{
		return true;
	}

	/**
	 * @return void
	 */
	public function onRestore($id)
	{
		// remove if unused
	}
}
