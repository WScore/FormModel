<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

class HtmlTextArea extends AbstractHtml
{
    /**
     * @return Input
     */
    public function form()
    {
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        $form = Form::textArea($name, $this->value() ?? '')->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }
}