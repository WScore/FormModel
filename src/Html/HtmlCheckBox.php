<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlCheckBox extends AbstractHtml
{
    public function label()
    {
        return '';
    }

    /**
     * @return Tag
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