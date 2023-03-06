<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class SimplePages
 *
 * @property \App\Models\SimplePage $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class SimplePages extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Типовые страницы';

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
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
			AdminColumn::link('title', 'Заголовок'),
            AdminColumn::custom('url', function($model) {
                return '<span class="copy-me">'.route('simple.page', trim($model->slug, '/')).'</span>';
            })->setLabel('URL (нажмите, чтобы скопировать)'),
			AdminColumn::boolean('active', 'Активность'),
			AdminColumn::text('created_at', 'Создано/Обновлено', 'updated_at')
				->setWidth('200px')
				->setOrderable(function ($query, $direction) {
					$query->orderBy('updated_at', $direction);
				})
				->setSearchable(false),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
		$form = AdminForm::card()->addBody([
			AdminFormElement::columns()
				->addColumn([
					AdminFormElement::text('title', 'Заголовок')->required()->addValidationRule('max:125', 'Длина заголовка должна быть не более 125 символов'),
					AdminFormElement::text('slug', 'URL (генерируется автоматически, если оставить поле пустым)'),
                    AdminFormElement::textarea('text', 'Текст')->required()->setHtmlAttribute('class', 'tinymce_full'),
					AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(1),
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
