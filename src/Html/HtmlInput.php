<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ElementInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

final class HtmlInput extends AbstractHtml
{
    /**
     * @var null|string
     */
    private $type;

    public function __construct(ElementInterface $element, string $name = null, string $type = null)
    {
        $this->type = $type;
        parent::__construct($element, $name);
    }

    /**
     * @return Input
     */
    public function form()
    {
        $type = $this->type ?? $this->element->getType();
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        if (is_string($this->inputs())) {
            $attributes['value'] = $this->inputs();
        }
        $form = Form::input($type, $name)->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }
}