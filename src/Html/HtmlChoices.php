<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\Html\Form;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;

final class HtmlChoices extends AbstractHtml
{
    /**
     * @return Choices
     */
    public function form()
    {
        $name = $this->fullName();
        $form = Form::choices($name, $this->makeChoices())
            ->setAttributes($this->element->getAttributes())
            ->setInitValue($this->value());
        $form->required($this->element->isRequired());
        $form->expand($this->element->isExpand());
        $form->multiple($this->element->isMultiple());
        return $form;
    }

    private function makeChoices(): array
    {
        $choices = $this->element->getChoices();
        if ($this->element->isExpand()) return $choices;
        if ($holder = $this->element->getPlaceholder()) {
            $choices = array_merge(['' => $holder], $choices);
        }
        return $choices;
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        $form = $this->form();
        return $form->getChoices();
    }
}