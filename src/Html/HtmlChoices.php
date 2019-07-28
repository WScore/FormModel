<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\Choice;
use WScore\FormModel\Element\ElementInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;

final class HtmlChoices extends AbstractHtml
{
    /**
     * HtmlChoices constructor.
     * @param ElementInterface|Choice $element
     * @param null $name
     */
    public function __construct(ElementInterface $element, $name = null)
    {
        parent::__construct($element, $name);
        if ($element->isExpand()) {
            foreach ($element->getChildren() as $key => $choice) {
                $html = $choice->createHtml();
                $html->setParent($this);
                $this[$key] = $html;
            }
        }
    }

    public function setInputs($inputs)
    {
        parent::setInputs($inputs);
        foreach ($this->getChildren() as $key => $child) {
            $child->setInputs(ValueAccess::get($inputs, $key));
        }
    }

    /**
     * @return Choices
     */
    public function form()
    {
        $name = $this->fullName();
        $form = Form::choices($name, $this->makeChoices())
            ->setAttributes($this->element->getAttributes())
            ->setInitValue($this->inputs());
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