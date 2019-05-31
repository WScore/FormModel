<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

class Html extends AbstractHtml
{
    /**
     * @param ToStringInterface $toString
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     * @return HtmlFormInterface
     */
    public static function create(ToStringInterface $toString, ElementInterface $element, HtmlFormInterface $parent=null): HtmlFormInterface
    {
        if ($element->getType() === ElementType::TYPE_CHOICE && $element instanceof ChoiceType) {
            return new HtmlChoices($toString, $element, $parent);
        }
        if ($element->isFormType() && $element instanceof FormType) {
            if ($element->isRepeatedForm()) {
                return new HtmlRepeatedForm($toString, $element, $parent);
            }
            return new HtmlForm($toString, $element, $parent);
        }
        $self = new self($toString, $element, $parent);

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