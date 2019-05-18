<?php
namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

class Html extends AbstractHtml
{
    /**
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     * @return HtmlFormInterface
     */
    public static function create(ElementInterface $element, HtmlFormInterface $parent=null): HtmlFormInterface
    {
        if ($element->getType() === ElementType::TYPE_CHOICE && $element instanceof ChoiceType) {
            return new HtmlChoices($element, $parent);
        }
        if ($element->isFormType() && $element instanceof FormType) {
            return new HtmlForm($element, $parent);
        }
        $self = new self($element, $parent);

        return $self;
    }

    /**
     * @return Input
     */
    public function form()
    {
        $type = $this->element->getType();
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        $form = Form::input($type, $name)->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}