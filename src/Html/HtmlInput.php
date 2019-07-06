<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ElementType;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

final class HtmlInput extends AbstractHtml
{
    private $type2html = [
        ElementType::DATETIME => 'datetime-local',
    ];
    /**
     * @return Input
     */
    public function form()
    {
        $type = $this->element->getType();
        $type = $this->type2html[$type] ?? $type;
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