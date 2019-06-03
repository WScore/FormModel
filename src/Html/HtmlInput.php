<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\Html\Form;
use WScore\Html\Tags\Input;

class HtmlInput extends AbstractHtml
{
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
}