<?php
namespace WScore\FormModel\Html;

use Traversable;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

class Html extends AbstractHtml
{
    /**
     * @var ElementInterface|ElementInterface|FormElementInterface
     */
    private $element;

    public static function create(ElementInterface $element): HtmlFormInterface
    {
        $self = new self();
        $self->element = $element;

        return $self;
    }

    /**
     * @return Input
     */
    public function form()
    {
        $type = $this->element->getType();
        $name = $this->element->getFullName();
        $attributes = $this->element->getAttributes();
        $form = Form::input($type, $name)->setAttributes($attributes);

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