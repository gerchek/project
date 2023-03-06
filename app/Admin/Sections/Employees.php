<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\EmployeeGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Employees
 *
 * @property \App\Models\Employee $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Employees extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Сотрудники';

    /**
     * @var string
     */
    protected $alias;
    /**
     * @var \App\Models\Employee
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
            AdminColumn::link('name', 'Фамилия и Имя'),
            AdminColumn::text('post', 'Должность'),
            AdminColumn::image('photo', 'Фотография'),
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

        if (!empty($request->employee_group_id)) {
            $display->setFilters(
                AdminDisplayFilter::custom('employee_group_id')->setCallback(function($query, $value) {
                    $query->where('employee_group_id', $value);
                })->setTitle("Раздел сотрудников: " . EmployeeGroup::where('id', $request->employee_group_id)->pluck('name')->first())
            );
        } else {
            $display->setColumns(
                AdminColumn::custom('Раздел сотрудника', function (Model $model) {
                    if (!empty($model->parent)) {
                        $groupName = $model->parent->where('id', $model->employee_group_id)->first()->name;
                        return "<a href=\"/admin/employees/?employee_group_id=$model->employee_group_id\">$groupName</a>";
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
                AdminFormElement::text('name', 'Фамилия и Имя')->required(),
                AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                AdminFormElement::text('post', 'Должность')->required(),
                AdminFormElement::image('photo', 'Фотография')->required(),
                AdminFormElement::textarea('short_text', 'Краткое описание'),
                AdminFormElement::textarea('full_text', 'Полное описание')->setHtmlAttribute('class', 'tinymce_full'),

                AdminFormElement::select('employee_group_id', 'Раздел сотрудника')
                    ->setModelForOptions(\App\Models\EmployeeGroup::class)
                    ->setSortable(false)
                    ->setDisplay('name')
                    ->required(),

                AdminFormElement::multiselect('schools', 'Направления спортивной школы')
                    ->setModelForOptions(\App\Models\SportSchool::class)
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