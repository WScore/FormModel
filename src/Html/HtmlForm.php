<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     * @param null|string $name
     */
    public function __construct(FormType $element, $name = null)
    {
        parent::__construct($element, $name);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $html = $child->createHtml();
            $html->setParent($this);
            $this[$name] = $html;
        }
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     */
    public function setInputs($inputs)
    {
        parent::setInputs($inputs);
        foreach ($this->element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name]->setInputs(ValueAccess::get($inputs, $name));
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
}