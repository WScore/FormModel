<?php
namespace WScore\FormModel\Html;

use WScore\Html\Form;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;

class HtmlChoices extends AbstractHtml
{
    /**
     * @return Choices
     */
    public function form()
    {
        $name = $this->fullName();
        $form = Form::choices($name, $this->element->getChoices())
            ->setAttributes($this->element->getAttributes())
        ->setInitValue($this->value());
        $form->required($this->element->isRequired());
        $form->expand($this->element->isExpand());
        $form->multiple($this->element->isMultiple());
        return $form;
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        $form = $this->form();
        return $form->getChoices();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}