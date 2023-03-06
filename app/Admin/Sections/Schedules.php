<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Schedules
 *
 * @property \App\Models\Schedule $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Schedules extends Section
{
    protected $checkAccess = false;

    protected $title = 'Расписание';

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
            AdminColumn::link('name', 'Название расписания'),
            AdminColumn::text('tag', 'Тэг'),
            AdminColumn::custom('url', function($model) {
                if ($model->type == 'pdf') {
                    return '<span class="copy-me">'.env('SITE_URL').'/'.trim($model->file, '/').'</span>';
                } else {
                    return '<div class="row-image text-center">
						        <a href="/'.trim($model->file, '/').'" data-toggle="lightbox">
									<img class="thumbnail lazyload" src="/'.trim($model->file, '/').'" data-src="/'.trim($model->file, '/').'" width="80px">
							    </a>
			                </div>';
                }
            })
                ->setLabel('Файл расписания (нажмите, чтобы посмотреть или скопировать ссылку)')
                ->setHtmlAttribute('class', 'text-center'),
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

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('name', 'Название расписания')->required()->unique(),
                    AdminFormElement::text('tag', 'Тэг')->required(),
                    AdminFormElement::file('file', 'Файл расписания (JPG, PDF, PNG)')
                        ->addValidationRule('mimes:pdf,jpg,jpeg,png')
                        ->required(),
                    AdminFormElement::textarea('text', 'Краткое описание'),
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