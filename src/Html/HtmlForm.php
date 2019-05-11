<?php
namespace WScore\FormModel\Html;

use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     */
    public function __construct(FormType $element)
    {
        parent::__construct($element);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name] = Html::create($child);
        }
    }

    /**
     * @return Tag
     */
    public function form()
    {
        $form = Form::open('', 'post')
            ->set('name', $this->element->getFullName());
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