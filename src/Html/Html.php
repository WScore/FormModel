<?php
declare(strict_types=1);

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
     * @param null $value
     * @return HtmlFormInterface
     */
    public static function create(ElementInterface $element, HtmlFormInterface $parent=null, $value = null): HtmlFormInterface
    {
        if ($element->getType() === ElementType::TYPE_CHOICE && $element instanceof ChoiceType) {
            return new HtmlChoices($element, $parent, $value);
        }
        if ($element->isFormType() && $element instanceof FormType) {
            return new HtmlForm($element, $parent, $value);
        }
        $self = new self($element, $parent, $value);

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
        if (is_string($this->value())) {
            $attributes['value'] = $this->value();
        }
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