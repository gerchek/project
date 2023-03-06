<?php

namespace App\Admin\Sections;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

class MainPage extends Section
{
    protected $checkAccess = false;

    protected $title = 'Настройки';

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
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();

        $tabs = AdminDisplay::tabbed([
            'Настройки главной страницы' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::image('about_photo_1', 'Фотография блока «О центре» №1')->required(),
                AdminFormElement::image('about_photo_2', 'Фотография блока «О центре» №2')->required(),
                AdminFormElement::textarea('about_desc', 'Описание блока «О центре»')->required(),
                AdminFormElement::text('slider_info_delay', 'Задержка инфослайдов баннера (мс)')->required(),
                AdminFormElement::text('slider_images_delay', 'Задержка изображений баннера (мс)')->required(),
            ]),
        ]);

        $form->addElement($tabs);
        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
