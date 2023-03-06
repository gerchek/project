<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminDisplayFilter;
use AdminColumnFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class FormFeedbacks
 *
 * @property \App\Models\FormFeedback $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class FormFeedbacks extends Section
{
    protected $checkAccess = false;

    protected $title = 'Обратная связь';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    /**
     * @return DisplayInterface
     */
    public function onDisplay(Request $request)
    {
        $feedbackColumns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Имя'),
            AdminColumn::text('phone', 'Телефон'),
            AdminColumn::text('page', 'Страница'),
            AdminColumn::text('created_at', 'Дата заявки'),
            AdminColumn::checkbox()->addStyle(null, '/css/admin/form-feedbacks/mass-deletion.css')->addScript(null, '/js/admin/form-feedbacks/mass-deletion.js'),
        ];

        $tableFeedback = AdminDisplay::datatablesAsync()
            ->setName("tableFeedback")
            ->setOrder([[0, 'desc']])
            ->paginate(20)
            ->setDisplaySearch(true)
            ->setColumns($feedbackColumns)
            ->setHtmlAttribute('class', 'table-primary table-hover');

        $tableFeedback->setFilters(
            AdminDisplayFilter::field('id')->setTitle("Новое сообщение из формы обратной связи")
        );

        $tabs = AdminDisplay::tabbed();

        $tabs->setElements([
            AdminDisplay::tab($tableFeedback)
                ->setIcon('<i class="glyphicon glyphicon-send"></i>')
                ->setLabel('Сообщения')
                ->setBadge(function () {
                    return \App\Models\FormFeedback::count();
                }),
        ]);

        $control = $tableFeedback->getColumns()->getControlColumn();

        $button = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            return '/admin/show_feedback_form/' . $model->getKey(); // Генерация ссылки
        }, 'Просмотр', 50);

        $button->setHtmlAttribute('class', 'btn-info');
        $button->setHtmlAttribute('target', '_blank');

        $control->addButton($button);

        return $tabs;
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }
}
