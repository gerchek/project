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
 * Class Galleries
 *
 * @property \App\Models\Gallery $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Galleries extends Section
{
    protected $checkAccess = false;

    protected $title = 'Галерея';

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
            AdminColumn::link('name', 'Название'),
            AdminColumn::custom('url', function($model) {
                return '<span class="copy-me">'.route('gallery.page', trim($model->slug, '/')).'</span>';
            })->setLabel('URL (нажмите, чтобы скопировать)'),
            AdminColumn::image('cover', 'Обложка')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('active', 'Активность'),
            AdminColumn::datetime('date', 'Дата публикации')
                ->setFormat('d-m-Y')
                ->setWidth('160px')
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatablesAsync()
            ->setName('firstdatatables')
            ->setOrder([[5, 'desc']])
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
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('name', 'Название')->required(),
                    AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                    AdminFormElement::text('slug', 'URL (если оставить пустым, заполнится автоматически)'),
                    AdminFormElement::image('cover', 'Обложка')->required(),
                    AdminFormElement::images('images', 'Изображения галереи')
                        ->storeAsJson()
                        ->required(),
                    AdminFormElement::datetime('date', 'Дата публикации (если оставить пустым, заполнится автоматически)')
                        ->setPickerFormat('d-m-Y'),
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