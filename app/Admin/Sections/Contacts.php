<?php

namespace App\Admin\Sections;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

class Contacts extends Section
{
    protected $checkAccess = false;

    protected $title = 'Контакты';

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
            'Контактные данные' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('phone_1', 'Телефон №1'),
                AdminFormElement::text('phone_1_desc', 'Описание для телефона №1'),
                AdminFormElement::text('phone_2', 'Телефон №2'),
                AdminFormElement::text('phone_2_desc', 'Описание для телефона №2'),
                AdminFormElement::text('email', 'E-mail'),
                AdminFormElement::text('address', 'Адрес')
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