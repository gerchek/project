<?php

namespace App\Admin\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\NewsGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class NewsItems
 *
 * @property \App\Models\NewsItem $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class NewsItems extends Section
{
    protected $checkAccess = false;

    protected $title = 'События';

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
                return '<span class="copy-me">'.route('news.page', trim($model->slug, '/')).'</span>';
            })->setLabel('URL (нажмите, чтобы скопировать)'),
            AdminColumn::image('image', 'Обложка')->setHtmlAttribute('class', 'text-center'),
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

        if (!empty($request->news_group_id)) {
            $display->setFilters(
                AdminDisplayFilter::custom('news_group_id')->setCallback(function($query, $value) {
                    $query->where('news_group_id', $value);
                })->setTitle("Раздел событий: " . NewsGroup::where('id', $request->news_group_id)->pluck('name')->first())
            );
        } else {
            $display->setColumns(
                AdminColumn::custom('Раздел события', function (Model $model) {
                    if (!empty($model->parent)) {
                        $groupName = $model->parent->where('id', $model->news_group_id)->first()->name;
                        return "<a href=\"/admin/news_items/?news_group_id=$model->news_group_id\">$groupName</a>";
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
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('name', 'Название')->required(),
                    AdminFormElement::checkbox('active', 'Активность')->setDefaultValue(true),
                    AdminFormElement::text('slug', 'URL (если оставить пустым, заполнится автоматически)'),
                    AdminFormElement::image('image', 'Обложка')->required(),
                    AdminFormElement::textarea('text', 'Описание')
                        ->required()
                        ->setHtmlAttribute('class', 'tinymce_full'),
                    AdminFormElement::datetime('date', 'Дата публикации (если оставить пустым, заполнится автоматически)')
                        ->setPickerFormat('d-m-Y'),
                    AdminFormElement::select('news_group_id', 'Раздел события')
                        ->setModelForOptions(\App\Models\NewsGroup::class)
                        ->setSortable(false)
                        ->setDisplay('name')
                        ->required(),
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