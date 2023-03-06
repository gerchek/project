<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\PricesGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Prices
 *
 * @property \App\Models\Price $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Prices extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Прайсы';

    /**
     * @var string
     */
    protected $alias;
    /**
     * @var \App\Models\Price
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

        if (!empty($request->prices_group_id)) {
            $display->setFilters(
                AdminDisplayFilter::custom('prices_group_id')->setCallback(function($query, $value) {
                    $query->where('prices_group_id', $value);
                })->setTitle("Раздел прайсов: " . PricesGroup::where('id', $request->prices_group_id)->pluck('name')->first())
            );
        } else {
            $display->setColumns(
                AdminColumn::custom('Раздел прайсов', function (Model $model) {
                    if (!empty($model->parent)) {
                        $groupName = $model->parent->where('id', $model->prices_group_id)->first()->name;
                        return "<a href=\"/admin/prices/?prices_group_id=$model->prices_group_id\">$groupName</a>";
                    } else {
                        return "&mdash;";
                    }
                })->setHtmlAttribute('class', 'text-center')
            );
        }

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
                AdminFormElement::text('duration', 'Продолжительность (мин)'),
                AdminFormElement::text('price', 'Стоимость')->required(),
                AdminFormElement::select('prices_group_id', 'Раздел прайса')
                    ->setModelForOptions(\App\Models\PricesGroup::class)
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