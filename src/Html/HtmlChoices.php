<?php
namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\Html\Form;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

class HtmlChoices extends AbstractHtml
{
    /**
     * @var ChoiceType
     */
    private $element;

    public function __construct(ChoiceType $element)
    {
        $this->element = $element;
    }

    /**
     * @return Input|Tag
     */
    public function form()
    {
        if (!$this->element->isExpand()) {
            return $this->formSelect();
        }
        $tag = Tag::create('div');
        foreach ($this->choices() as $choice) {
            $tag->setContents($choice);
        }
        return $tag;
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        if (!$this->element->isExpand()) {
            return [];
        }
        $name = $this->element->getFullName();
        $type = $this->element->isMultiple()
            ? 'checkbox'
            : 'radio';
        $attributes = $this->element->getAttributes();
        $form = Form::input($type, $name)->setAttributes($attributes);
        $form->required($this->element->isRequired());

        $inputs = [];
        foreach ($this->element->getChoices() as $val => $label) {
            $f = clone $form;
            $f->value($val);
            $f->set('aria-label', $label);
            $inputs[$val] = $f;
        }
        return $inputs;
    }

    private function formSelect()
    {

    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}