<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplayFilter;
use AdminForm;
use AdminDisplay;
use AdminFormElement;
use App\Models\Socnet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Socnets
 *
 * @property \App\Models\Socnet $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Socnets extends Section implements Initializable
{
    protected $checkAccess = false;

    protected $title = 'Социальные сети';

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
     * @return DisplayInterface
     */
    public function onDisplay(Request $request)
    {
        $columns = [
            AdminColumn::text('name', 'Название')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::image('image', 'Иконка'),
            AdminColumn::text('link', 'Ссылка')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('order', 'Сортировка')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('active', 'Активность')
        ];

        $display = AdminDisplay::datatables()
            ->setOrder([[3, 'asc']])
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
                AdminFormElement::select('type', 'Тип', [
                    'ok' => 'ok',
                    'vk' => 'vk',
                    'youtube' => 'youtube',
                    // 'tiktok' => 'tiktok',
                    // 'instagram' => 'instagram',
                    // 'facebook' => 'facebook',
                ])->required(),
                AdminFormElement::image('image', 'Иконка (png или svg)')->addValidationRule('mimes:png,svg')->required(),
                AdminFormElement::text('link', 'Ссылка')->required(),
                AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                AdminFormElement::text('order', 'Сортировка')->setDefaultValue($maxOrderVal + 1),
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