<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use App\Models\SportSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class SportSchools
 *
 * @property \App\Models\SportSchool $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class SportSchools extends Section
{
    protected $checkAccess = false;

    protected $title = 'Спортивная школа';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay(Request $request)
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('name', 'Направление'),
            AdminColumn::custom('url', function($model) {
                return '<span class="copy-me">'.route('sport_school.page', trim($model->slug, '/')).'</span>';
            })->setLabel('URL (нажмите, чтобы скопировать)'),
            AdminColumn::image('icon', 'Иконка')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('order', 'Сортировка')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('active', 'Активность'),
        ];

        $display = AdminDisplay::datatablesAsync()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(20)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $maxOrderVal = $this->model->max('id');

        $formMain = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                AdminFormElement::text('slug', 'URL (если оставить пустым, заполнится автоматически)'),
                AdminFormElement::svgimage('icon', 'Иконка (SVG)'),
                AdminFormElement::images('gallery', 'Галерея изображений')
                    ->storeAsJson()
                    ->required(),
                AdminFormElement::text('order', 'Сортировка')->setDefaultValue(($maxOrderVal + 1)),
            ], 'col'),
        );

        $formBanner = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::image('banner', 'Баннер')->required(),
                AdminFormElement::textarea('banner_text', 'Текст баннера')->required(),
                AdminFormElement::checkbox('banner_form', 'Выводить форму «Оставить заявку»?')->setDefaultValue(0),
            ], 'col')
        );

        $formDesc = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('desc_title', 'Заголовок')->required(),
                AdminFormElement::textarea('desc_text', 'Описание')->required()->setHtmlAttribute('class', 'tinymce_full'),
                AdminFormElement::images('desc_images', 'Изображения (до 3шт)')
                    ->storeAsJson()
                    ->required()
            ], 'col')
        );

        $formRelations = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('schedule_id', 'Расписание')
                    ->setModelForOptions(\App\Models\Schedule::class)
                    ->setSortable(false)
                    ->setDisplay('name')
                    ->required(),

                AdminFormElement::multiselect('employees', 'Тренеры')
                    ->setModelForOptions(\App\Models\Employee::class)
                    ->setSortable(false)
                    ->setDisplay('name')
                    ->required(),

                AdminFormElement::html('<hr/>'),

                AdminFormElement::checkbox('main', 'Выводить на главной?')->setDefaultValue(false),
                AdminFormElement::textarea('main_text', 'Описание на главной'),
            ], 'col')
        );

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) use ($formMain, $formBanner, $formDesc, $formRelations) {
            $tabs = [];
            $tabs[] = $formMain->setLabel('Основное');
            $tabs[] = $formBanner->setLabel('Баннер');
            $tabs[] = $formDesc->setLabel('О спорте');
            $tabs[] = $formRelations->setLabel('Связи');

            return $tabs;
        });

        $form = AdminForm::card()->setElements([$tabs]);

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