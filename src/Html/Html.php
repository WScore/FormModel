<?php
namespace WScore\FormModel\Html;

use Traversable;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Html\Form;

class Html extends AbstractHtml
{
    /**
     * @var BaseElementInterface|ElementInterface|FormElementInterface
     */
    private $element;

    public static function create(BaseElementInterface $element): HtmlFormInterface
    {
        $self = new self();
        $self->element = $element;

        return $self;
    }

    /**
     * @return string
     */
    public function form()
    {
        $type = $this->element->getType();
        $name = $this->element->getFullName();
        $value = $this->element->getValue();
        $attributes = $this->element->getAttributes();
        $form = Form::input($type, $name, $value)->setAttributes($attributes);

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