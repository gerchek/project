<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\DocumentsGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class DocumentsItems
 *
 * @property \App\Models\DocumentsItem $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class DocumentsItems extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Документы';

    /**
     * @var string
     */
    protected $alias;
    /**
     * @var \App\Models\DocumentsItem
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
            AdminColumn::custom('url', function($model) {
                return '<span class="copy-me">'.env('SITE_URL').'/'.trim($model->file, '/').'</span>';
            })
                ->setLabel('URL (нажмите, чтобы скопировать)')
                ->setHtmlAttribute('class', 'text-center'),
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

        if (!empty($request->documents_group_id)) {
            $display->setFilters(
                AdminDisplayFilter::custom('documents_group_id')->setCallback(function($query, $value) {
                    $query->where('documents_group_id', $value);
                })->setTitle("Группа документов: " . DocumentsGroup::where('id', $request->documents_group_id)->pluck('name')->first())
            );
        } else {
            $display->setColumns(
                AdminColumn::custom('Группа документа', function (Model $model) {
                    if (!empty($model->parent)) {
                        $groupName = $model->parent->where('id', $model->documents_group_id)->first()->name;
                        return "<a href=\"/admin/documents_items/?documents_group_id=$model->documents_group_id\">$groupName</a>";
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
                AdminFormElement::file('file', 'Документ')
                    ->addValidationRule('mimes:pdf,doc,docx')
                    ->required(),
                AdminFormElement::select('documents_group_id', 'Раздел новости')
                    ->setModelForOptions(\App\Models\DocumentsGroup::class)
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