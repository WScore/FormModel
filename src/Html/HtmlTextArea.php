<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\Html\Form;
use WScore\Html\Tags\Input;

final class HtmlTextArea extends AbstractHtml
{
    /**
     * @return Input
     */
    public function form()
    {
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        $form = Form::textArea($name, $this->inputs() ?? '')->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }
}