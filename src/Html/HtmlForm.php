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
     * @param HtmlFormInterface|null $parent
     */
    public function __construct(FormType $element, HtmlFormInterface $parent=null)
    {
        parent::__construct($element, $parent);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name] = Html::create($child, $this);
        }
    }

    /**
     * @return Tag
     */
    public function form()
    {
        $form = Form::open('', 'post')
            ->set('name', $this->fullName());
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