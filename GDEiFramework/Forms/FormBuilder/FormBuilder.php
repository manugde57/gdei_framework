<?php
namespace GDEiFramework\Forms\FormBuilder;

use \GDEiFramework\Forms\Form;
use \GDEiFramework\Entity;

abstract class FormBuilder
{
    protected $form;

    public function __construct(Entity $entity)
    {
        $this->setForm(new Form($entity));
    }

    abstract public function build();

    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}
