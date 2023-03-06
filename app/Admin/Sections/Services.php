<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use App\Models\ServicePrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Services
 *
 * @property \App\Models\Service $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Services extends Section
{
    protected $checkAccess = false;

    protected $title = 'Услуги';

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
            AdminColumn::text('name', 'Название')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::image('image', 'Изображение')->setHtmlAttribute('class', 'text-center'),
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
        $maxPriceOrderVal = (new ServicePrice)->max('id');

        $formMain = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::textarea('text', 'Описание'),
                AdminFormElement::image('image', 'Изображение')->required(),
                AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                AdminFormElement::text('order', 'Сортировка')->setDefaultValue(($maxOrderVal + 1)),
            ], 'col'),
        );

        $formPrices = AdminDisplay::tab(
            AdminFormElement::columns()->addColumn([
                AdminFormElement::hasMany('prices', [
                    AdminFormElement::text('name', 'Название')->required(),
                    AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                    AdminFormElement::text('duration', 'Продолжительность'),
                    AdminFormElement::text('price', 'Стоимость')->required(),
                    AdminFormElement::text('order', 'Сортировка')->setDefaultValue(($maxPriceOrderVal + 1)),
                ]),
            ], 'col')
        );

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) use ($formMain, $formPrices) {
            $tabs = [];
            $tabs[] = $formMain->setLabel('Основное');
            $tabs[] = $formPrices->setLabel('Цены услуги');

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