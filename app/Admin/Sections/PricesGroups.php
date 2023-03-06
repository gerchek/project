<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class PricesGroups
 *
 * @property \App\Models\PricesGroup $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class PricesGroups extends Section
{
    protected $checkAccess = false;

    protected $title = 'Разделы прайсов';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('name', 'Название')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::count('childs', 'Прайсы')->append(
                AdminColumn::custom(' ', function (Model $model) {
                    if (!empty($model->childs->first())) {
                        return "<a href=\"/admin/prices/?prices_group_id=$model->id\">
                                <i data-toggle=\"tooltip\" title=\"\" class=\"fa fa-rub\" data-original-title=\"Посмотреть прайсы\"></i>
                                </a>";
                    }
                })->setHtmlAttribute('style', 'display: inline-flex')
            )->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('order', 'Сортировка')->setHtmlAttribute('class', 'text-center')
        ];

        $display = AdminDisplay::datatables()
            ->setOrder([[2, 'asc']])
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

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                AdminFormElement::text('name', 'Название')->required(),
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