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
        $value = $this->element->getValue();
        $attributes = $this->element->getAttributes();
        if (is_string($value)) {
            $attributes['value'] = $value;
        }
        if ($this->isChecked()) {
            $attributes['checked'] = 'checked';
        }
        $form = Form::input($type, $name)->setAttributes($attributes);
        $id = $form->get('id') . '_' . $value;
        $form->reset('id', $id);
        $form->required($this->element->isRequired());

        return $form;
    }

    private function isChecked()
    {
        $inputs = $this->inputs();
        if (is_null($inputs) || empty($inputs)) {
            return false;
        }
        $value = $this->element->getValue();
        if (is_array($inputs)) {
            return in_array($value, $inputs, true);
        }
        return $inputs === $value;
    }
}