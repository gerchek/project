<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class ServicePrices
 *
 * @property \App\Models\ServicePrice $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ServicePrices extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Цены услуг';

    /**
     * @var string
     */
    protected $alias;
    /**
     * @var \App\Models\ServicePrice
     */
    protected $model;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        //
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay(Request $request)
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('name', 'Название')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('duration', 'Продолжительность')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('price', 'Стоимость')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('order', 'Сортировка')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('active', 'Активность'),
        ];

        $display = AdminDisplay::datatablesAsync()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
            ->paginate(25)
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

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                AdminFormElement::text('duration', 'Продолжительность'),
                AdminFormElement::text('price', 'Стоимость')->required(),
                AdminFormElement::select('service_id', 'Услуга прайса')
                    ->setModelForOptions(\App\Models\Service::class)
                    ->setSortable(false)
                    ->setDisplay('name')
                    ->required(),
                AdminFormElement::text('order', 'Сортировка')->setDefaultValue(($maxOrderVal + 1)),
            ], 'col-12')
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