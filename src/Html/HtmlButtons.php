<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ButtonType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

final class HtmlButtons extends AbstractHtml
{
    /**
     * @var ButtonType
     */
    protected $element;

    /**
     * @return Tag
     */
    public function form()
    {
        $type = $this->element->getType();
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        if (is_string($this->inputs())) {
            $attributes['value'] = $this->element->getValue();
        }
        $form = Form::input($type, $name)->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }
}